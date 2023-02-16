import { writable } from "svelte/store";
export const loggedIn = writable(false)
export const current_User = writable(null);

export const login = async (username, password) => {
    const formData = new FormData();
    formData.append('username', username);
    formData.append('password', password);
    const res = await fetch('http://localhost:3000/back-end_development/check_login.php', {
        method: 'post',
        body: formData
    });
}