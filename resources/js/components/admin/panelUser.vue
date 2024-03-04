
<template>
  <Card>
    <template #content>
      <DataTable v-model:filters="filters" :value="customers" paginator :rows="10" dataKey="id" filterDisplay="row" :loading="loading"
              :globalFilterFields="['nickname', 'email', 'name', 'surname']">
          <template #header>
              <div class="flex justify-content-end">
                  <IconField iconPosition="left">
                      <InputIcon>
                          <i class="pi pi-search" />
                      </InputIcon>
                      <InputText v-model="filters['global'].value" placeholder="Keyword Search" />
                  </IconField>
              </div>
          </template>
          <template #empty> No customers found. </template>
          <template #loading> Loading customers data. Please wait. </template>

          <Column field="nickname" header="Nickname" style="min-width: 12rem">
              <template #body="{ data }">
                  {{ data.nickname }}
              </template>
              <template #filter="{ filterModel, filterCallback }">
                  <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter" placeholder="Search by nickname" />
              </template>
          </Column>

          <Column header="Email" filterField="email" style="min-width: 12rem">
            <template #body="{ data }">
                  {{ data.email }}
              </template>
              <template #filter="{ filterModel, filterCallback }">
                  <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter" placeholder="Search by email" />
              </template>
          </Column>
          
          <Column header="Name" filterField="name" style="min-width: 12rem">
            <template #body="{ data }">
                  {{ data.name }}
              </template>
              <template #filter="{ filterModel, filterCallback }">
                  <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter" placeholder="Search by name" />
              </template>
          </Column>

          <Column header="Surname" filterField="surname" style="min-width: 12rem">
            <template #body="{ data }">
                  {{ data.surname }}
              </template>
              <template #filter="{ filterModel, filterCallback }">
                  <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter" placeholder="Search by surname" />
              </template>
          </Column>

          

          <Column field="type" header="Status" :showFilterMenu="false" :filterMenuStyle="{ width: '14rem' }" style="min-width: 12rem">
              <template #body="{ data }">
                  <Tag :value="data.type" :severity="getSeverity(data.type)" />
              </template>
              <template #filter="{ filterModel, filterCallback }">
                  <Dropdown v-model="filterModel.value" @change="filterCallback()" :options="statuses" placeholder="Select One" class="p-column-filter" style="min-width: 12rem" :showClear="true">
                      <template #option="slotProps">
                          <Tag :value="slotProps.option" :severity="getSeverity(slotProps.option)" />
                      </template>
                  </Dropdown>
              </template>
          </Column>

          
          <Column field="active" header="Active" dataType="boolean" style="min-width: 6rem">
              <template #body="{ data }">
                  <i class="pi" :class="{ 'pi-check-circle text-green-500': data.active, 'pi-times-circle text-red-400': !data.active }"></i>
              </template>
              <template #filter="{ filterModel, filterCallback }">
                  <TriStateCheckbox v-model="filterModel.value" @change="filterCallback()" />
              </template>
          </Column>

          <Column header="" style="min-width: 8rem">
              <template #body="{ data }">
                  <div class="button-delete">
                    <i class="pi pi-trash" style="color: #B52A2A" />
                  </div>
              </template>
          </Column>

      </DataTable>
    </template>
  </Card>
</template>

<script>
import { FilterMatchMode } from 'primevue/api';
import { CustomerService } from './CustomerService';

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import InputIcon from 'primevue/inputicon';
import IconField from 'primevue/iconfield';
import MultiSelect from 'primevue/multiselect';
import Dropdown from 'primevue/dropdown';
import Tag from 'primevue/tag';
import TriStateCheckbox from 'primevue/tristatecheckbox';
import Card from 'primevue/card';


export default {
  data() {
    return {
      customers: null,
      filters: {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        nickname: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
        name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
        surname: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
        type: { value: null, matchMode: FilterMatchMode.EQUALS },
        active: { value: null, matchMode: FilterMatchMode.EQUALS },
        email: { value: null, matchMode: FilterMatchMode.STARTS_WITH }
      },
      statuses: ['Provider', 'Rider', 'Admin'],
      loading: true
    };
  },
  methods: {
    getCustomers(data) {
      return [...(data || [])].map((d) => {
        d.date = new Date(d.date);
        return d;
      });
    },
    getSeverity(status) {
      switch (status) {
        case 'Rider':
          return 'warning';
        case 'Provider':
          return 'success';
        case 'Admin':
          return 'info';
      }
    }
  },
  mounted() {
    CustomerService.getCustomersMedium().then((data) => {
      this.customers = this.getCustomers(data);
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
    Card
  } 
};

</script>

<style>
  .p-card{
    margin: 20px;
    border-radius: 5px;
    font-family: Poppins, sans-serif;
  }


  .button-delete{
    border-radius: 50%;
    border: 1px solid #B52A2A;
    height: 40px;
    width: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .p-inputtext:hover{
    border-color: #984EAE;
  }

  .p-inputtext:focus{
    outline: 1px solid #984EAE;
  }

  .p-highlight .p-checkbox-box {
    background-color: #984EAE;
    border-color: #984EAE;
  }

  .p-column-filter-overlay .p-column-filter-row-items .p-column-filter-row-item.p-highlight {
    background-color: #ebe1d7;
    color: #B48753;
  }

  .p-paginator .p-highlight {
    background-color: #ebe1d7;
    color: #B48753;
    border-radius: 50%;
  }
  
</style>