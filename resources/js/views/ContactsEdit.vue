<template>
    <div>
  
        <div class="flex justify-between">
            <a href="#" div class="bg-blue justify-left" @click="$router.back()">                  
                <svg class="h-8 w-8 fill-current text-blue inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 13h8V7h-8V2l-8 8 8 8v-5z"/></svg>
            </a>
            
        </div>
        <flash-message class="z-100" :position="'right top'"></flash-message>
        <form @submit.prevent="submitForm" class="pt-6">
            
            <InputField name="name" label="Contact Name" :errors="errors"
            placeholder="Contact Name" @update:field="form.name = $event" :data="form.name" />
            <InputField name="email" label="Contact Email" :errors="errors"
            placeholder="Contact Email" @update:field="form.email = $event" :data="form.email" />
            <InputField name="company" label="Company" :errors="errors"
            placeholder="Company" @update:field="form.company = $event" :data="form.company" />
            <!--
            <InputField name="birthday" label="Birthday" :errors="errors"
            placeholder="MM/DD/YYYY" @update:field="form.birthday = $event" :data="form.birthday" />
            -->
            <label class="text-blue-500 pt-2 uppercase text-xs font-bold absolute">Birth Date</label>
            <date-picker 
                text-gray-900-4xl
                v-model="form.birthday" 
                value-type="M/D/YYYY" 
                format="M/D/YYYY" 
                class="leading-normal pt-8 w-full text-gray-900 border-b pb-2 focus:outline-none focus:border-blue-400"
            ></date-picker>

            <div class="flex justify-end">
                <router-link to="/contacts">
                    <button class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700">Cancel</button>
                </router-link>
                <div v-if="this.$route.params.id != 0">
                    <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400">Update</button>
                </div>
                <div v-else>
                    <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400">Save</button>
                </div>
            </div>
 
        </form>
 
       </div>
</template>

<script>
    import InputField from '../components/InputField';
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';

    export default {
        name: "ContactsEdit",

        components: {
            InputField, DatePicker
         },

        mounted() {
            if (this.$route.params.id != 0) {
                axios.get('/api/contacts/' + this.$route.params.id)
                .then(response => {
                    this.form = response.data.data;
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;

                    if (error.response.status === 404) {
                        this.$router.push('/contacts');
                    }
                });

            } else {                
                console.log('Load Initial Form Data');
                console.log(this.form);
            }
        },

        props: {
            editMode: null
        },


        data: function () {
            return {
                form: {
                    'name': '',
                    'email': '',
                    'company': '',
                    'birthday': '',
                },
                message: {
                    text: '',
                    type: ''
                },
                errors: null,
                loading: true,
            }
        },

        methods: {
            submitForm: async function () {
                console.log(this.$route.params.id);
                if ( this.$route.params.id != 0 ) {
                    await axios.patch('/api/contacts/' + this.$route.params.id, this.form)
                        .then(response => {
                            this.flashMessage.success({
                                message: 'Contact has been updated',
                                time: 2000
                            })
                            setTimeout( () => {
                                this.$router.push('/contacts')
                                }, 2000)
 //                           this.$router.push('/contacts');
                        })
                        .catch(errors => {
                           this.flashMessage.error({
                                message: 'Contact has not been updated',
                                time: 2000
                            })
                        });
                } else {
                console.log("Create");
                    await axios.post('/api/contacts', this.form )
                    .then(response => {
                        this.flashMessage.success({
                            message: 'Contact has been created',
                            time: 2000
                        }) 
                        setTimeout( () => {
                            this.$router.push('/contacts')
                            }, 2000)
                    })
                    .catch(errors => {
                        console.log(errors);
                        this.errors = errors.response.data.errors;
                    });             
                }    
            }
        },
        
    }
</script>

<style scoped>

</style>