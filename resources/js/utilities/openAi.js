import OpenAI from "openai";

let apiKey = "process"
const openai = new OpenAI({ apiKey, dangerouslyAllowBrowser: true });
const instructions = "Proyecto Connexió Solidària: Plataforma de Gestión de Alimentos para una Comunidad Más Justa y Sostenible. Descripción: Crear una comunidad justa y sostenible mediante una plataforma web para coordinar voluntarios en la recolección y distribución de alimentos excedentes. Objetivos: Reducir el malgasto alimentario, apoyar a comunidades vulnerables, sensibilizar y empoderar a voluntarios. Beneficios: Impacto social positivo, sostenibilidad ambiental y cohesión comunitaria. Demandas: Interfaz intuitiva, imagen de marca, gestión de voluntarios, coordinación de proveedores, mapa de destinos, sistemas de ayuda, seguimiento e informes, uso de IA, comunicación eficaz, seguridad, escalabilidad, integración con redes sociales y ONGs, análisis y mejora continua.";
export const handleOpenAi = async (req, res) => {
  const assistant = await openai.beta.assistants.create({
    name: "StreetFeed Assist",
    model: "gpt-3.5-turbo",
    instructions: instructions,
  });

  const thread = await openai.beta.threads.create();
  const message = await openai.beta.threads.messages.create(thread.id, {
    role: "user",
    content: req,
  });
  const run = await openai.beta.threads.runs.create(thread.id, {
    assistant_id: assistant.id,
  });

  await checkStatus(thread.id, run.id);
  const messages = await openai.beta.threads.messages.list(thread.id);
  res.status(200).send({
    answer: messages.body.data[0].content[0].text.value,
  });
};

async function checkStatus(threadId, runId) {
    try {
      let isComplete = false;
      while (!isComplete) {
        const runStatus = await openai.beta.threads.runs.retrieve(threadId, runId);
        if (runStatus && runStatus.status === "completed") {
          isComplete = true;
        } else {
          await new Promise((resolve) => setTimeout(resolve, 2000));
        }
      }
    } catch (error) {
      console.error("Error al verificar el estado de ejecución:", error);
    }
  }
  