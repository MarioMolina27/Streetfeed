export const CustomerService = {
    getData() {
        return [
            {
                "nickname": "Prueba 1",
                "email": "jbutt@example.com",
                "name": "James",
                "surname": "Butt",
                "type": 'Rider',
                "active": true
            },
            {
                "nickname": "Prueba 2",
                "email": "josephine_darakjy@example.com",
                "name": "Josephine",
                "surname": "Darakjy",
                "type": "Provider",
                "active": true
            },
            {
                "nickname": "Prueba 3",
                "email": "art@example.com",
                "name": "Art",
                "surname": "Venere",
                "type": "Admin",
                "active": false
            },
            {
                "nickname": "Prueba 4",
                "email": "lenna@example.com",
                "name": "Lenna",
                "surname": "Paprocki",
                "type": "Rider",
                "active": true
            },
            {
                "nickname": "Prueba 5",
                "email": "donette.foller@example.com",
                "name": "Donette",
                "surname": "Foller",
                "type": "Provider",
                "active": true
            },
            {
                "nickname": "Prueba 6",
                "email": "john.doe@example.com",
                "name": "John",
                "surname": "Doe",
                "type": "Rider",
                "active": true
            },
            {
                "nickname": "Prueba 7",
                "email": "jane.doe@example.com",
                "name": "Jane",
                "surname": "Doe",
                "type": "Provider",
                "active": true
            },
            {
                "nickname": "Prueba 8",
                "email": "michael.smith@example.com",
                "name": "Michael",
                "surname": "Smith",
                "type": "Admin",
                "active": false
            },
            {
                "nickname": "Prueba 9",
                "email": "sarah.jones@example.com",
                "name": "Sarah",
                "surname": "Jones",
                "type": "Rider",
                "active": true
            },
            {
                "nickname": "Prueba 10",
                "email": "emily.wilson@example.com",
                "name": "Emily",
                "surname": "Wilson",
                "type": "Provider",
                "active": true
            },
            {
                "nickname": "Prueba 11",
                "email": "alexander.brown@example.com",
                "name": "Alexander",
                "surname": "Brown",
                "type": "Admin",
                "active": false
            }
        ];
    },

    getCustomersSmall() {
        return Promise.resolve(this.getData().slice(0, 10));
    },

    getCustomersMedium() {
        return Promise.resolve(this.getData().slice(0, 50));
    },

    getCustomersLarge() {
        return Promise.resolve(this.getData().slice(0, 200));
    },

    getCustomersXLarge() {
        return Promise.resolve(this.getData());
    },

    getCustomers(params) {
        const queryParams = params
            ? Object.keys(params)
                  .map((k) => encodeURIComponent(k) + '=' + encodeURIComponent(params[k]))
                  .join('&')
            : '';

        return fetch('https://www.primefaces.org/data/customers?' + queryParams).then((res) => res.json());
    }
};
