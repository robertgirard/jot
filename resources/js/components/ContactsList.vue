<template>
    <div>
        <div v-if="loading">Loading...</div>
        <div v-else class="flex">
            <div v-if="contacts.length === 0">
                <p>No contacts yet. <router-link to="/contact/create">Get Started ></router-link></p>
            </div>
            <table class="table-auto">                
                <thead>
                    <tr>
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Name</th>
                        <th class="border px-4 py-2">Company</th>
                        <th class="border px-4 py-2">e-mail</th>
                        <th class="border px-4 py-2">Birth Date</th>                
                        <th class="border px-4 py-2">Modify</th>
                    </tr>
                </thead>
                <tr v-for="contact in contacts" :key="contact.data.id">
                    <td class="border px-4 py-2"><UserCircle :name="contact.data.name" /></td>
                    <td class="border px-4 py-2">{{ contact.data.name }}</td>
                    <td class="border px-4 py-2">{{ contact.data.company }}</td>
                    <td class="border px-4 py-2">{{ contact.data.email }}</td>
                    <td class="border px-4 py-2">{{ contact.data.birthday }}</td>                    
                    <td class="border py-2">
                        <!--
                        <router-link :to="'/contacts/' + contact.data.contact_id" class="px-2 hover:bg-gray-100">
                        <router-link :to="'/contacts/' + contact.data.contact_id + '/edit'" class="px-2 hover:bg-gray-100">
                        <router-link :to="{ path: '/contacts/' + contact.data.contact_id + '/edit', query: { editMode: 'edit' }}" class="px-2 hover:bg-gray-100">                                                
                           @click="modal = ! modal"                                                
                        -->

                        <router-link :to="'/contacts/' + contact.data.contact_id + '/edit'" class="px-2 hover:bg-gray-100">
                            <font-awesome-icon icon="edit" style="color: blue;" size="lg"/>
                        </router-link>
                        <!--
                        <router-link :to="'/contacts/' + contact.data.contact_id" class="px-2 hover:bg-gray-100">
                                                       class="px-4 py-2 border border-red-500 rounded text-sm font-bold text-red-500"
                        </router-link>
                        -->
                        <a 
                           href="#"
                           @click="destroy(contact.data.contact_id)"
                        >
                            <font-awesome-icon icon="trash-alt" style="color: red;" size="lg"/>
                        </a>
                     </td>                        
                </tr>
            </table>
            <!--
            <div 
                v-if="modal"
                class="absolute bg-blue-900 text-white rounded-lg z20 p-8 w-64 right-0 mt-2 mr-6"
                >
                <p>Are you sure you want to delete this record ?</p>
                <div class="flex items-center mt-6 justify-end">
                    <button 
                        class="px-4 py-2 mr-4 bg-green-500 rounded text-sm fond-bold text-white"
                        @click="modal = !modal">Cancel
                    </button>
                    <button 
                        class="px-4 py-2 bg-red-500 rounded text-sm font-bold text-white"
                        @click.prevent="destroy"
                    >Delete
                    </button>
                </div>
            </div>
                       <flash-message class="relative z-50"></flash-message>
            -->
 
        </div>

    </div>
</template>

<script>
    import UserCircle from './UserCircle';
    export default {
        name: "ContactsList",

        components: {
            UserCircle,
         },
        props: [
            'endpoint',
        ],

        mounted() {
            console.log(this.endpoint);
   
            axios.get(this.endpoint)
                .then(response => {
                    console.log(response);
                    this.contacts = response.data.data;
                    this.loading = false;
                 })
                .catch(error => {
                    this.loading = false;

                    alert('Unable to fetch contacts.');
                });
        },

        data: function () {
            return {
                loading: true,
                contacts: null,
                modal: false,
                tableKey: 0,
                message: {
                    text: '',
                    type: ''
                },
            }
        },

        methods: {

            destroy: function (id) {
                swal({
                    title: "Are you sure?",
                    text: "Are you sure you want to delete this record ?",                   
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        axios.delete('/api/contacts/' + id)
                            .then(response => {
                               for ( var i = 0; i < this.contacts.length; i++ ) {
                                    if ( this.contacts[i].data.contact_id == id ) {
                                    this.contacts.splice(i, 1);
                                    }
                                }
                                swal("Contact has been successfully deleted", {
                                    icon: success,
                                    buttons: false,
                                    timer: 2000,
                                });
                        })
                        .catch(error => {
                            swal({ 
                                text: "Internal Error...Contact Was Not Deleted !", 
                                buttons: false,
                                dangermode: true,
                                timer: 2000,
                            });
   
                        });
                    }
                        else {
                            swal("Deletion Cancelled !", {
                                buttons: false,
                                timer: 2000,
                            });
                        }
 
                    });
  
 

            }
            

        }
    }
</script>

<style scoped>

</style>