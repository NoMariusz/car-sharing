import { API_PATH } from "./constants";
import { userData } from "./stores";

export const updateUserData = async () => {
    const res = await fetch(API_PATH + "public/getUserInfo.php");
    const data = await res.json();

    userData.set({
        ...data,
    });
};
