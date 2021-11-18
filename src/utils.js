import { get } from "svelte/store";
import { ADMIN_ROLE, API_PATH, MOD_ROLE } from "./constants";
import { userData } from "./stores";

export const updateUserData = async () => {
    const res = await fetch(API_PATH + "public/getUserInfo.php");
    const data = await res.json();

    userData.set({
        ...data,
        user: {
            ...data.user,
        },
    });
};

export const checkIfStuffMember = () => {
    const ud = userData;
    return (
        get(ud).user.role_id == MOD_ROLE || get(ud).user.role_id == ADMIN_ROLE
    );
};
