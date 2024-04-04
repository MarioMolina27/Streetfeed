export const getAllMarkers = async() => {
    const url = 'api/markers/all';
    try{
        const response = await axios.get(url);
        const data = await response.data;
        return response;
    }
    catch(error){
        console.log('Error:', error);
    }
}

export const markersByUser = async(id) => {
    const url = `api/markers/markersByUser/${id}`;
    try{
        const response = await axios.get(url);
        const data = await response.data;
        return data;
    }
    catch(error){
        console.log('Error:', error);
    }
}