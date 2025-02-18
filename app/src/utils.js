
import {getAuthenticatedUser as getUser} from './apiService.js';
import store from '@/store';
import router from '@/router'

export async function  getAuthenticatedUser()
{
    try {
        await getUser().then((response)=>{
            store.commit('setCurrentUser', response.result.user);
        });
     } catch(err) {
        console.log(err);
        redirectToLogin();
    }

}

export function redirectToLogin() 
{
    console.log('path',router.currentRoute.path);
    if (router.currentRoute.path !== '/login') {
        // Redirect to the login route
        router.push('/login');
      }
  }
