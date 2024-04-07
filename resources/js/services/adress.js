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

export const getAdressByUser = async (id) => {
    const url = `api/adress/getAdressesByUser/${id}`;
    try{
        const response = await axios.get(url);
        const data = await response.data;
        return data;
    }
    catch(error){
        console.log('Error:', error);
    }
}

export const getTypeRoad = async () => {
    const url = `api/adress/getTypeRoad`;
    console.log(url);
    try{
        const response = await axios.get(url);
        console.log(response);
        const data = await response.data;
        return data;
    }
    catch(error){
        console.log('Error:', error);
    }
}