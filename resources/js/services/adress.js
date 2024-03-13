export const getCitiesNumbers = async (idType) => {
    const url = `api/adress/numberAdress/${idType}`;
    try{
        const response = await axios.get(url);
        const data = await response.data;
        return data;
    }
    catch(error){
        console.log('Error:', error);
    }
}