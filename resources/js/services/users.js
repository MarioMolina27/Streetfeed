export const fecthAllUsers = async () => {
    const url = 'api/users';
    try{
        const response = await axios.get(url);
        const data = await response.data;

        data.map((user) => {
            user.active = Boolean(user.active);
            user.type_users = user.type_users.map((type) => {
                return type.name
            })   
        });
        
        return data;
    }
    catch(error){
        console.log('Error:', error);
    }
}

export const deleteUser = async (id) => {
    console.log(id);
    const url = `api/users/${id}`;
    try{
        const response = await axios.delete(url);
        const data = await response.data;
        return data;
    }
    catch(error){
        console.log('Error:', error);
    }
}

export const reactivateUser = async (id) => {
    console.log(id);
    const url = `api/users/reactivate/${id}`;
    try{
        const response = await axios.post(url);
        const data = await response.data;
        return data;
    }
    catch(error){
        console.log('Error:', error);
    }
}

export const getUsersTypesNumbers = async () => {
    const url = 'api/users/getUsersNums';
    try{
        const response = await axios.get(url);
        const data = await response.data;
        return data;
    }
    catch(error){
        console.log('Error:', error);
    }
}