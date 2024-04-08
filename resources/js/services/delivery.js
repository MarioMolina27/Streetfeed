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

export const getTotalDeliveries = async () => {
    const url = 'api/delivery/getTotalDeliveries';
    try{
        const response = await axios.get(url);
        const data = await response.data;
        return data;
    }
    catch(error){
        console.log('Error:', error);
    }
}

export const getDeliveriesByUser = async (id) => {
    const url = `api/delivery/getDeliveriesByUser/${id}`;
    try{
        const response = await axios.get(url);
        const data = await response.data;
        return data;
    }
    catch(error){
        console.log('Error:', error);
    }
}

export const getDeliveriesByKgUser = async (id) => {
    const url = `api/delivery/getDeliveriesByKgUser/${id}`;
    try{
        const response = await axios.get(url);
        const data = await response.data;
        return data;
    }
    catch(error){
        console.log('Error:', error);
    }
}

export const getNumProviderDeliveries = async (id) => {
    const url = `api/delivery/getNumProviderDeliveries/${id}`;
    try{
        const response = await axios.get(url);
        const data = await response.data;
        return data;
    }
    catch(error){
        console.log('Error:', error);
    }
}

