<script>
    import { API_PATH, HOME_PATH } from "../constants";

    import { updateUserData } from "../utils";
    let login = "";
    let email = "";
    let password = "";

    const registerUser = async () => {
        const myHeaders = new Headers();
        myHeaders.append("Login", login);
        myHeaders.append("Password", encodeURIComponent(password));
        myHeaders.append("email", email);

        const res = await fetch(API_PATH + "public/register.php", {
            headers: myHeaders,
            method: "POST",
        });
        const data = await res.json();

        if (data.result) {
            await updateUserData();
            // console.log("User updated");
            window.location.href = HOME_PATH;
        } else {
            alert(`Can not create account, reason: ${data.msg}`);
        }
    };
</script>

<section class="text-gray-40">
    <div class="container px-5 py-24 mx-auto flex flex-wrap items-center">
        <div
            class="lg:w-2/6 md:w-1/2 bg-primary-light bg-opacity-50 rounded-lg p-8 flex flex-col md:m-auto w-full mt-10 md:mt-0"
        >
            <h2 class="text-black text-lg font-medium title-font mb-5">
                Sign up
            </h2>
            <div class="relative mb-4">
                <label for="full-name" class="leading-7 text-sm text-gray-800"
                    >Login</label
                >
                <input
                    type="text"
                    id="full-name"
                    name="full-name"
                    class=""
                    bind:value={login}
                />
            </div>
            <div class="relative mb-4">
                <label for="email" class="leading-7 text-sm text-gray-800"
                    >Email</label
                >
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="w-full bg-gray-600 bg-opacity-20 focus:bg-transparent focus:ring-2 focus:ring-indigo-900 rounded border border-gray-600 focus:border-indigo-500 text-base outline-none text-gray-100 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                    bind:value={email}
                />
            </div>
            <div class="relative mb-4">
                <label for="pass" class="leading-7 text-sm text-gray-800"
                    >Password</label
                >
                <input
                    type="password"
                    id="pass"
                    name="pass"
                    class="w-full bg-gray-600 bg-opacity-20 focus:bg-transparent focus:ring-2 focus:ring-indigo-900 rounded border border-gray-600 focus:border-indigo-500 text-base outline-none text-gray-100 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                    bind:value={password}
                />
            </div>
            <button class="" on:click={registerUser}>Register</button>
            <p class="text-xs mt-3">
                Without a account you can't reserve a car :(
            </p>
        </div>
    </div>
</section>

<style>
    input {
        @apply w-full bg-gray-100 bg-opacity-20 focus:bg-transparent focus:ring-2 focus:ring-primary rounded border border-gray-600 focus:border-primary-dark text-base outline-none text-gray-900 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out;
    }
    button {
        @apply text-black bg-accent border-0 py-2 px-8 focus:outline-none hover:bg-primary-dark rounded text-lg;
    }
</style>
