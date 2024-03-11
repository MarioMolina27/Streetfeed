<template>
    <ConfirmDialog> </ConfirmDialog>
    <Card>
        <template #content>
            <DataTable
                v-model:filters="filters"
                :value="users"
                paginator
                :rows="10"
                dataKey="id"
                filterDisplay="row"
                :loading="loading"
                :globalFilterFields="['nickname', 'email', 'name', 'surnames']"
                scrollable
            >
                <template #header>
                    <div class="flex justify-content-end">
                        <IconField iconPosition="left">
                            <InputIcon>
                                <i class="pi pi-search" />
                            </InputIcon>
                            <InputText
                                v-model="filters['global'].value"
                                placeholder="Keyword Search"
                            />
                        </IconField>
                    </div>
                </template>
                <template #empty> No users found. </template>
                <template #loading> Loading users data. Please wait. </template>

                <Column
                    field="nickname"
                    header="Nickname"
                    style="min-width: 12rem"
                >
                    <template #body="{ data }">
                        {{ data.nickname }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText
                            v-model="filterModel.value"
                            type="text"
                            @input="filterCallback()"
                            class="p-column-filter"
                            placeholder="Search by nickname"
                        />
                    </template>
                </Column>

                <Column
                    header="Email"
                    filterField="email"
                    style="min-width: 12rem"
                >
                    <template #body="{ data }">
                        {{ data.email }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText
                            v-model="filterModel.value"
                            type="text"
                            @input="filterCallback()"
                            class="p-column-filter"
                            placeholder="Search by email"
                        />
                    </template>
                </Column>

                <Column
                    header="Name"
                    filterField="name"
                    style="min-width: 12rem"
                >
                    <template #body="{ data }">
                        {{ data.name }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText
                            v-model="filterModel.value"
                            type="text"
                            @input="filterCallback()"
                            class="p-column-filter"
                            placeholder="Search by name"
                        />
                    </template>
                </Column>

                <Column
                    header="Surname"
                    filterField="surnames"
                    style="min-width: 12rem"
                >
                    <template #body="{ data }">
                        {{ data.surnames }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText
                            v-model="filterModel.value"
                            type="text"
                            @input="filterCallback()"
                            class="p-column-filter"
                            placeholder="Search by surname"
                        />
                    </template>
                </Column>

                <Column
                    field="type_users"
                    header="Status"
                    :showFilterMenu="false"
                    :filterMenuStyle="{ width: '14rem' }"
                    style="min-width: 12rem"
                >
                    <template #body="{ data }">
                        <div
                            v-if="data.type_users && data.type_users.length > 0"
                        >
                            <Tag
                                v-for="(typeUser, index) in data.type_users"
                                :key="index"
                                :value="typeUser"
                                :severity="getSeverity(typeUser)"
                            />
                        </div>
                        <div v-else>No type users</div>
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <Dropdown
                            v-model="filterModel.value"
                            @change="filterCallback()"
                            :options="statuses"
                            placeholder="Select One"
                            class="p-column-filter"
                            style="min-width: 12rem"
                            :showClear="true"
                        >
                            <template #option="slotProps">
                                <Tag
                                    :value="slotProps.option"
                                    :severity="getSeverity(slotProps.option)"
                                />
                            </template>
                        </Dropdown>
                    </template>
                </Column>

                <Column
                    field="active"
                    header="Active"
                    dataType="boolean"
                    style="min-width: 6rem"
                >
                    <template #body="{ data }">
                        <img
                            v-if="!data.active"
                            :src="userNotActiveImg"
                            alt="active"
                            width="20"
                            height="20"
                            class="not-active-user"></img>
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <TriStateCheckbox
                            v-model="filterModel.value"
                            @change="filterCallback()"
                        />
                    </template>
                </Column>

                <Column
                    header=""
                    style="min-width: 8rem"
                    frozen
                    alignFrozen="right"
                >
                    <template #body="{ data }">
                        <button
                            v-if="data.active"
                            class="button-delete"
                            @click="openDialog(data.id_user, true)"
                        >
                            <i class="pi pi-lock" style="color: #b52a2a"></i>
                        </button>

                        <button
                            v-else
                            class="button-reactivate"
                            @click="openDialog(data.id_user, false)"
                        >
                            <i class="pi pi-lock-open" style="color: #9fa7a1" />
                        </button>
                    </template>
                </Column>
            </DataTable>
        </template>
    </Card>
</template>

<script>
import { FilterMatchMode } from "primevue/api";
import { userNotActiveImg } from "../../utilities/constant.js";
import {
    deleteUser,
    reactivateUser,
    fecthAllUsers,
} from "../../services/users.js";

import DataTable from "primevue/datatable";
import Column from "primevue/column";
import InputText from "primevue/inputtext";
import InputIcon from "primevue/inputicon";
import IconField from "primevue/iconfield";
import MultiSelect from "primevue/multiselect";
import Dropdown from "primevue/dropdown";
import Tag from "primevue/tag";
import TriStateCheckbox from "primevue/tristatecheckbox";
import Card from "primevue/card";
import ConfirmDialog from "primevue/confirmdialog";
import Button from "primevue/button";

import { ref } from "vue";
const isVisible = ref(false);


export default {
    name: "UsersTable",
    data() {
        return {
            userNotActiveImg,
            users: null,
            visible: false,
            filters: {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                nickname: {
                    value: null,
                    matchMode: FilterMatchMode.STARTS_WITH,
                },
                name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                surnames: {
                    value: null,
                    matchMode: FilterMatchMode.STARTS_WITH,
                },
                type_users: { value: null, matchMode: FilterMatchMode.CONTAINS },
                active: { value: null, matchMode: FilterMatchMode.EQUALS },
                email: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
            },
            statuses: ["Provider", "Rider", "Admin"],
            loading: true,
        };
    },
    methods: {
        getusers(data) {
            return [...(data || [])].map((d) => {
                d.date = new Date(d.date);
                return d;
            });
        },

        getSeverity(status) {
            switch (status) {
                case "Rider":
                    return "warning";
                case "Provider":
                    return "success";
                case "Admin":
                    return "info";
            }
        },

        deleteUser(id) {
            deleteUser(id).then(() => {
                this.users.find((customer) => {
                    if (customer.id_user === id) {
                        customer.active = false;
                    }
                });
            });
        },

        reactivateUser(id) {
            reactivateUser(id).then(() => {
                this.users.find((customer) => {
                    if (customer.id_user === id) {
                        customer.active = true;
                    }
                });
            });
        },

        openDialog(id, isDeleting) {
            if (isDeleting) {
                this.$confirm.require({
                    message: "Are you sure you want to desactivate the user?",
                    header: "Delete",
                    onShow: () => {
                        isVisible.value = true;
                    },
                    onHide: () => {
                        isVisible.value = false;
                    },
                    accept: () => {
                        this.deleteUser(id);
                        isVisible.value = false;
                    },
                });
            } else {
                this.$confirm.require({
                    message: "Are you sure you want to reactivate the user?",
                    header: "Reactivate",
                    onShow: () => {
                        isVisible.value = true;
                    },
                    onHide: () => {
                        isVisible.value = false;
                    },
                    accept: () => {
                        this.reactivateUser(id);
                        isVisible.value = false;
                    },
                });
            }
        },
    },
    mounted() {
        fecthAllUsers().then((data) => {
            this.users = this.getusers(data);
            this.loading = false;
        });
    },

    components: {
        DataTable,
        Column,
        InputText,
        InputIcon,
        IconField,
        MultiSelect,
        Dropdown,
        Tag,
        TriStateCheckbox,
        Card,
        ConfirmDialog,
        Button,
    },
};
</script>

<style>
.p-card {
    margin: 20px;
    border-radius: 5px;
    font-family: Poppins, sans-serif;
}

.button-delete {
    border-radius: 50%;
    border: 1px solid #b52a2a;
    height: 40px;
    width: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: transparent;
}

.button-reactivate {
    border-radius: 50%;
    border: 1px solid #9fa7a1;
    height: 40px;
    width: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: transparent;
}

.p-inputtext:hover {
    border-color: #984eae;
}

.p-inputtext:focus {
    outline: 1px solid #984eae;
}

.p-highlight .p-checkbox-box {
    background-color: #984eae;
    border-color: #984eae;
}

.p-column-filter-overlay
    .p-column-filter-row-items
    .p-column-filter-row-item.p-highlight {
    background-color: #ebe1d7;
    color: #b48753;
}

.p-paginator .p-highlight {
    background-color: #ebe1d7;
    color: #b48753;
    border-radius: 50%;
}

.p-tag {
    margin: 0 5px;
}

.p-dropdown-label .p-inputtext:focus .p-placeholder {
    outline: none;
}

.p-dropdown:not(.p-disabled).p-focus {
    outline: 1px solid #984eae;
}

.p-inputtext.p-dropdown-label:focus {
    outline: none;
}

.p-button {
    border-radius: 5px;
    font-family: Poppins, sans-serif;
}

.p-confirm-dialog-accept {
    background-color: #984eae !important;
    color: white;
    border: none;
}

.p-confirm-dialog-reject {
    background-color: white !important;
    color: #984eae;
    border: none;
    border: 2px solid #984eae;
}

.active-user {
    color: #4caf50;
}

.not-active-user {
    fill: #b52a2a;
}

.navbar {
    display: none;
}
</style>