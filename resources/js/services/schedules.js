export const getScheduleByUser = async (id) => {
    const url = `api/schedule/getScheduleByUser/${id}`;
    console.log(url);
    try{
        const response = await axios.get(url);
        const data = await response.data;
        return data;
    }
    catch(error){
        console.log('Error:', error);
    }
}