<template>
    <div>
        <div v-if="loading">Loading...</div>
        <div v-else>
            <div class="flex justify-between">
                <a href="#" div class="bg-blue justify-left" @click="$router.back()">                  
                   <svg class="h-8 w-8 fill-current text-blue inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 13h8V7h-8V2l-8 8 8 8v-5z"/></svg>
                </a>
                <div class="relative">
                    <router-link 
                        :to="'/contacts/' + contact.contact_id + '/edit'"
                        class="px-4 py-2 rounded text-sm text-green-500 border border-green-500 text-sm font-bold mr-2"
                    >Edit</router-link>
                    <a 
                        href="#" 
                        class="px-4 py-2 border border-red-500 rounded text-sm font-bold text-red-500"
                        @click="modal = ! modal"                        
                    >Delete</a>
                    <div 
                        v-if="modal"
                        class="absolute bg-blue-900 text-white rounded-lg z20 p-8 w-64 right-0 mt-2 mr-6"
                        >
                        <p>Are you sure you want to delete this record ?</p>
                        <div class="flex items-center mt-6 justify-end">
                            <button 
                                class="px-4 py-2 mr-4 bg-green-500 rounded text-sm fond-bold text-white"
                                @click="modal = ! modal">Cancel
                            </button>
                            <button 
                                class="px-4 py-2 bg-red-500 rounded text-sm font-bold text-white"
                                @click.prevent="destroy"
                            >Delete
                            </button>
                        </div>
                    </div>
                </div>
                <!--
                <div v-if="modal" class="bg-black opacity-25 absolute right-0 left-0 top-0 bottom-0 z-10" @click="modal = ! modal"></div>
                -->
            </div>

            <div class="flex items-center pt-6">
                <UserCircle :name="contact.name"/>
                <p class="pl-5 text-xl">{{ contact.name }}</p>
            </div>
            <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Contact</p>
            <p class="pt-2 text-blue-400">{{ contact.email }}</p>
            <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Company</p>
            <p class="pt-2 text-blue-400">{{ contact.company }}</p>
            <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Birthday</p>
            <p class="pt-2 text-blue-400">{{ contact.birthday }}</p>
        </div>
    </div>
</template>

<script>
    import UserCircle from '../components/UserCircle';
    export default { 
        name: "ContactsShow",
        components: { UserCircle },
        mounted() {
            this.loading=true;
            axios.get('/api/contacts/' + this.$route.params.id)
                .then(response => {
                    this.contact = response.data.data;
                    console.log(this.contact);
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;

                    if (error.response === 404) {
                        this.$router.push('/contacts');
                    }

                });
        },

        data: function () {
            return {
                loading: true,
                contact: null,
                modal: false,
            }
        },

        methods: {
            destroy: function () {
                console.log('destroy contact # ' + this.$route.params.id);
                axios.delete('/api/contacts/' + this.$route.params.id)
                    .then(response => {

                        this.$router.push('/contacts');
                    })
                    .catch(error => {
                        alert('Internal Error.  Unable to delete contact!');
                    });

            }

        }
    }
</script>

<style scoped>

</style>