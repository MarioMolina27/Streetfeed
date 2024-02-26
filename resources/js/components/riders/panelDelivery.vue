<template>
  <div class="card">
    <DataView :value="products" :layout="layout">
      <template #header>
        <div class="d-flex justify-content-end">
          <DataViewLayoutOptions v-model="layout" />
        </div>
      </template>

      <template #list="slotProps">
        <div class="row">
          <div
            v-for="(item, index) in slotProps.items"
            :key="index"
            class="col-12"
          >
            <div
              class="d-flex flex-column flex-sm-row align-items-sm-center p-4 gap-3"
              :class="{ 'border-top-1 border-light': index !== 0 }"
            >
              <div class="md-w-10rem position-relative">
                <img
                  class="img-fluid border rounded"
                  :src="`https://primefaces.org/cdn/primevue/images/product/${item.image}`"
                  :alt="item.name"
                />
                <Tag
                  :value="item.inventoryStatus"
                  :severity="getSeverity(item)"
                  class="position-absolute"
                  style="left: 4px; top: 4px"
                ></Tag>
              </div>
              <div class="flex-grow-1 d-flex flex-column md-flex-row justify-content-between md-align-items-center gap-4">
                <div class="d-flex flex-row md-flex-column justify-content-between align-items-start gap-2">
                  <div>
                    <span class="font-medium text-secondary text-sm">{{
                      item.category
                    }}</span>
                    <div class="text-lg font-medium text-dark mt-2">
                      {{ item.name }}
                    </div>
                  </div>
                  <div
                    class="bg-light p-1"
                    style="border-radius: 30px"
                  >
                    <div
                      class="bg-white d-flex align-items-center gap-2 justify-content-center py-1 px-2"
                      style="
                        border-radius: 30px;
                        box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.04),
                          0px 1px 2px 0px rgba(0, 0, 0, 0.06);
                      "
                    >
                      <span class="text-dark font-medium text-sm">
                        {{ item.rating }}
                      </span>
                      <i class="pi pi-star-fill text-warning"></i>
                    </div>
                  </div>
                </div>
                <div class="d-flex flex-column md-align-items-end gap-5">
                  <span class="text-xl font-semibold text-dark">
                    ${{ item.price }}
                  </span>
                  <div class="d-flex flex-row-reverse md-flex-row gap-2">
                    <Button
                      icon="pi pi-heart"
                      outlined
                    ></Button>
                    <Button
                      icon="pi pi-shopping-cart"
                      label="Buy Now"
                      :disabled="item.inventoryStatus === 'OUTOFSTOCK'"
                      class="flex-grow-1 md-flex-initial white-space-nowrap"
                    ></Button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>

      <template #grid="slotProps">
        <div class="row">
          <div
            v-for="(item, index) in slotProps.items"
            :key="index"
            class="col-12 col-sm-6 col-md-4 col-xl-6 p-2"
          >
            <div class="p-4 border border-light rounded">
              <div class="bg-light rounded p-3 d-flex justify-content-center">
                <div class="position-relative mx-auto">
                  <img
                    class="img-fluid rounded"
                    :src="`https://primefaces.org/cdn/primevue/images/product/${item.image}`"
                    :alt="item.name"
                    style="max-width: 300px"
                  />
                  <Tag
                    :value="item.inventoryStatus"
                    :severity="getSeverity(item)"
                    class="position-absolute"
                    style="left: 4px; top: 4px"
                  ></Tag>
                </div>
              </div>
              <div class="pt-4">
                <div class="d-flex justify-content-between align-items-start gap-2">
                  <div>
                    <span class="font-medium text-secondary text-sm">{{
                      item.category
                    }}</span>
                    <div class="text-lg font-medium text-dark mt-1">
                      {{ item.name }}
                    </div>
                  </div>
                  <div
                    class="bg-light p-1"
                    style="border-radius: 30px"
                  >
                    <div
                      class="bg-white d-flex align-items-center gap-2 justify-content-center py-1 px-2"
                      style="
                        border-radius: 30px;
                        box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.04),
                          0px 1px 2px 0px rgba(0, 0, 0, 0.06);
                      "
                    >
                      <span class="text-dark font-medium text-sm">
                        {{ item.rating }}
                      </span>
                      <i class="pi pi-star-fill text-warning"></i>
                    </div>
                  </div>
                </div>
                <div class="d-flex flex-column gap-4 mt-4">
                  <span class="text-2xl font-semibold text-dark">
                    ${{ item.price }}
                  </span>
                  <div class="d-flex gap-2">
                    <Button
                      icon="pi pi-shopping-cart"
                      label="Buy Now"
                      :disabled="item.inventoryStatus === 'OUTOFSTOCK'"
                      class="flex-grow-1 white-space-nowrap"
                    ></Button>
                    <Button
                      icon="pi pi-heart"
                      outlined
                    ></Button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>
    </DataView>
  </div>
</template>


<script >
    import DataView from 'primevue/dataview';
    import Button from 'primevue/button';
    import Tag from 'primevue/tag';
    import DataViewLayoutOptions from 'primevue/dataviewlayoutoptions' 

export default{
    data(){
        return {
            products: [
                {
                    id: '1000',
                    code: 'f230fh0g3',
                    name: 'Bamboo Watch',
                    description: 'Product Description',
                    image: 'bamboo-watch.jpg',
                    price: 65,
                    category: 'Accessories',
                    quantity: 24,
                    inventoryStatus: 'INSTOCK',
                    rating: 5
                },
                {
                    id: '1001',
                    code: 'nvklal433',
                    name: 'Black Watch',
                    description: 'Product Description',
                    image: 'black-watch.jpg',
                    price: 72,
                    category: 'Accessories',
                    quantity: 61,
                    inventoryStatus: 'INSTOCK',
                    rating: 4
                },
                {
                    id: '1002',
                    code: 'zz21cz3c1',
                    name: 'Blue Band',
                    description: 'Product Description',
                    image: 'blue-band.jpg',
                    price: 79,
                    category: 'Fitness',
                    quantity: 2,
                    inventoryStatus: 'LOWSTOCK',
                    rating: 3
                },
                {
                    id: '1002',
                    code: 'zz21cz3c1',
                    name: 'Blue Band',
                    description: 'Product Description',
                    image: 'blue-band.jpg',
                    price: 79,
                    category: 'Fitness',
                    quantity: 2,
                    inventoryStatus: 'LOWSTOCK',
                    rating: 3
                },
                {
                    id: '1002',
                    code: 'zz21cz3c1',
                    name: 'Blue Band',
                    description: 'Product Description',
                    image: 'blue-band.jpg',
                    price: 79,
                    category: 'Fitness',
                    quantity: 2,
                    inventoryStatus: 'LOWSTOCK',
                    rating: 3
                },
                {
                    id: '1002',
                    code: 'zz21cz3c1',
                    name: 'Blue Band',
                    description: 'Product Description',
                    image: 'blue-band.jpg',
                    price: 79,
                    category: 'Fitness',
                    quantity: 2,
                    inventoryStatus: 'LOWSTOCK',
                    rating: 3
                },
            ],
            layout: 'grid'
        }
    },
    mounted() {
        
    },
    components: {
        DataView,
        Button,
        Tag,
        DataViewLayoutOptions
    },
    methods: {
        getSeverity(product) {
            switch (product.inventoryStatus) {
                case 'INSTOCK':
                    return 'success';

                case 'LOWSTOCK':
                    return 'warning';

                case 'OUTOFSTOCK':
                    return 'danger';

                default:
                    return null;
            }
        }
    }
}
</script>
