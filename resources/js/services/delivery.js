export const getDeliveriesKg = async () => {
    const url = 'api/delivery/totalKg';
    try{
        const response = await axios.get(url);
        const data = await response.data;
        return data;
    }
    catch(error){
        console.log('Error:', error);
    }
}

export const getDeliveriesByMonth = async () => {
    const url = 'api/delivery/deliveryNumbers';
    try{
        const response = await axios.get(url);
        const data = await response.data;
        return data;
    }
    catch(error){
        console.log('Error:', error);
    }
}