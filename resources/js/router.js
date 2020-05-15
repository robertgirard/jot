import Vue from 'vue';
import VueRouter from 'vue-router';
import Contacts from './views/Contacts.vue';
import ContactsCreate from './views/ContactsCreate.vue';
import ContactsShow from './views/ContactsShow.vue';
import ContactsEdit from './views/ContactsEdit.vue';
import ContactsIndex from './views/ContactsIndex.vue';
import ProfileCreate from './views/ProfileCreate.vue'
import BirthdaysIndex from './views/BirthdaysIndex.vue';
import Logout from './actions/Logout.vue';

Vue.use(VueRouter);


export default new VueRouter({

  routes: [
    { 
        path: '/', 
        component: ContactsIndex,
        meta: { title: 'Contacts' }

    },
    { 
      path: '/contacts', 
      component: ContactsIndex, 
      meta: { title: 'Contacts'} 
    },
    { 
      path: '/contacts/create2', 
      component: Contacts,
      meta: { title: 'Contacts Management'} 
    },
    { 
      path: '/contacts/create', 
      component: ContactsCreate,
      meta: { title: 'Add New Contacts'} 
    },
    { 
      path: '/contacts/:id', 
      component: ContactsShow,
      meta: { title: 'Contact Details'} 
    },
    { 
      path: '/contacts/:id/edit', 
      component: ContactsEdit,
      props: true,
      meta: { title: 'Edit Contact' }
    },
    { 
      path: '/birthdays', 
      component: BirthdaysIndex,
      meta: { title: 'Birthdays !'} 
    },
    { 
      path: '/logout', 
      component: Logout,
    },
],
  mode: 'history'

});
