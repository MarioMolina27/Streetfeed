<?php
    namespace App\ApiLibraries;
    use GuzzleHttp\Client;

    class ChatGptApi {
        //*************************************************************************/
        //****************** Creacion del chatbot de ChatGPT **********************/
        //*       creara el asistente de chatgpt y retornara el id del chatbot    */
        //*       tambien se puede realizar desde el panel de assistance de OpenAI*/
        //*************************************************************************/
        public function createAssistance() {
            $apiKey = env('OPENAI_API_KEY');

            $client = new Client();
    
            $data = [
                "name" => "Vueltia Chatbot",
                "instructions" => "Eres un chatbot de un portal de tours llamado Vueltia, no me respondas a ninguna pregunta no relacionada con el portal de tour",
                "model" => "gpt-3.5-turbo"
            ];
    
          
            $url = 'https://api.openai.com/v1/assistants';
    
           
            $headers = [
                'Authorization' => "Bearer $apiKey",
                'Content-Type' => 'application/json',
                'OpenAI-Beta' => 'assistants=v2'
            ];
    
            try {
                $response = $client->request('POST', $url, [
                    'headers' => $headers,
                    'json' => $data
                ]);
    
                $body = $response->getBody();
    
                $responseData = json_decode($body, true);
    
                $chatbotId = $responseData['id'];
    
                return $chatbotId;
            } catch (\Exception $e) {
                throw new \Exception('Error al crear el chatbot: ' . $e->getMessage());
            }
        }

        //*************************************************************************/
        //************************ Creacion del thread *************************** /
        //*       creacion del thread que representa una conversa con el chat     */
        //*************************************************************************/
        public function createThread(){
            $apiKey = env('OPENAI_API_KEY');
            $client = new Client();
    
            $url = 'https://api.openai.com/v1/threads';
    
            $headers = [
                'Authorization' => "Bearer $apiKey",
                'Content-Type' => 'application/json',
                'OpenAI-Beta' => 'assistants=v2'
            ];
    
            try {
                $response = $client->request('POST', $url, [
                    'headers' => $headers,
                ]);
    
                $responseData = json_decode($response->getBody(), true);
    
                $threadId = $responseData['id'];
    
                return $threadId;
            } catch (\Exception $e) {
                throw new \Exception('Error al crear el hilo: ' . $e->getMessage());
            }
        }

        //*************************************************************************/
        //************************ Envio de mensajes *************************** /
        //*    envio del mensaje al assistente de chatgpt para su ejecución      */
        //*************************************************************************/
        public function addMessage($threadId, $message) {
            $apiKey = env('OPENAI_API_KEY');
            $client = new Client();


            $url = "https://api.openai.com/v1/threads/$threadId/messages";
    
            $headers = [
                'Authorization' => "Bearer $apiKey",
                'Content-Type' => 'application/json',
                'OpenAI-Beta' => 'assistants=v2'
            ];

            $data = [
                'role' => 'user',
                'content' => $message
            ];
    
            try {
                $response = $client->request('POST', $url, [
                    'headers' => $headers,
                    'json' => $data
                ]);

                $runId = $this->runThread($threadId);

                $run = $this->isRunComplete($threadId, $runId);
                while ($run['status'] === 'in_progress') {
                    sleep(1); 
                    $run = $this->isRunComplete($threadId, $runId);
                }

                switch ($run['status']) {
                    case 'completed':
                        $messages = $this->listMessages($threadId);
                        $response = $messages[0]['content'][0]['text']['value'];
                        return response()->json(['success' => $response], 200);
                    case 'failed':
                        $errorMessage = $run['last_error']['message'];
                        return response()->json(['error' => $errorMessage], 400);
                    case 'cancelling':
                    case 'cancelled':
                        $errorMessage = "La ejecución del hilo ha sido cancelada.";
                        return response()->json(['error' => $errorMessage], 400);
                    case 'requires_action':
                    case 'expiring':
                        $errorMessage = "La ejecución del hilo está en progreso o requiere acción.";
                        return response()->json(['error' => $errorMessage], 400);
                    case 'expired':
                        $errorMessage = "La ejecución del hilo ha expirado.";
                        return response()->json(['error' => $errorMessage], 400);
                    default:
                    dd($run);
                        $errorMessage = "Estado de ejecución no reconocido.";
                        return response()->json(['error' => $errorMessage], 400);
                }
            } catch (\Exception $e) {
                throw new \Exception('Error al enviar el mensaje: ' . $e->getMessage());
            }
        }


         //*************************************************************************/
        //********************* Comprobación estado de la run ********************* /
        //* comprobacion del estado de la run para saber si se pueden coger ya los mensajes */
        //*************************************************************************/
        private function isRunComplete($threadId, $runId) {
            $apiKey = env('OPENAI_API_KEY');
            $client = new Client();
        
            $url = "https://api.openai.com/v1/threads/$threadId/runs/$runId";
        
            $headers = [
                'Authorization' => "Bearer $apiKey",
                'Content-Type' => 'application/json',
                'OpenAI-Beta' => 'assistants=v2'
            ];
        
            try {
                $response = $client->request('GET', $url, [
                    'headers' => $headers
                ]);
        
                $responseData = json_decode($response->getBody(), true);
                return $responseData;
            } catch (\Exception $e) {
                throw new \Exception('Error al verificar el estado de la ejecución: ' . $e->getMessage());
            }
        }

        //*************************************************************************/
        //************************ Hacer el run del hilo *************************** /
        //*  ejecutar el hilo del chatbot con todos los mensajes previamente añadidos */
        //*               te retorna el id de la run en curso                   */
        //*************************************************************************/
        private function runThread($threadId){
            $apiKey = env('OPENAI_API_KEY');
            $assistantId = env('OPENAI_ASSISTANCE_ID');

            $client = new Client();
    
            $url = "https://api.openai.com/v1/threads/$threadId/runs";
    
            $headers = [
                'Authorization' => "Bearer $apiKey",
                'Content-Type' => 'application/json',
                'OpenAI-Beta' => 'assistants=v2'
            ];
    
            $data = [
                'assistant_id' => $assistantId,
            ];
    
            try {
                $response = $client->request('POST', $url, [
                    'headers' => $headers,
                    'json' => $data
                ]);
                $responseData = json_decode($response->getBody(), true);
                
                return $responseData['id'];
            } catch (\Exception $e) {
                throw new \Exception('Error al iniciar la ejecución: ' . $e->getMessage());
            }
        }

        //*************************************************************************/
        //********************* Listar la respuesta del thread ******************* /
        //*  recoge la respuesta del thread y la devuelve para enviarsela al controlador */
        //*************************************************************************/
        private function listMessages($threadId) {
            $apiKey = env('OPENAI_API_KEY');
    
            $client = new Client();
    
            $url = "https://api.openai.com/v1/threads/$threadId/messages";
    
            $headers = [
                'Authorization' => "Bearer $apiKey",
                'Content-Type' => 'application/json',
                'OpenAI-Beta' => 'assistants=v2'
            ];
    
            try {
                $response = $client->request('GET', $url, [
                    'headers' => $headers
                ]);
    
                $responseData = json_decode($response->getBody(), true);
                return $responseData['data'];
            } catch (\Exception $e) {
                throw new \Exception('Error al listar los mensajes: ' . $e->getMessage());
            }
        }
    }
?>