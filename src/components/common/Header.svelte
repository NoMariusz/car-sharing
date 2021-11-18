<script>
    import { API_PATH, HOME_PATH } from "../../constants";

    import { userData } from "../../stores";
    import { updateUserData } from "../../utils";

    export let isStuff;

    const logout = async () => {
        await fetch(API_PATH + "public/logout.php");
        await updateUserData();
    };
</script>

<main>
    <header class="text-white body-font bg-primary-dark">
        <div
            class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center"
        >
            <a
                href={HOME_PATH}
                class="flex title-font font-medium items-center mb-4 md:mb-0 flex-1 nohover"
            >
                <span class="text-xl white-txt">Car Sharing</span>
            </a>
            <nav
                class="md:ml-auto md:mr-auto flex flex-wrap items-center text-base justify-center flex-auto"
            >
                <a href="#/home" class="mr-5 white-txt">Home</a>
                <a href="#/login" class="mr-5 white-txt">Login</a>
                <a href="#/register" class="mr-5 white-txt">Register</a>
                {#if isStuff}
                    <a href="#/admin" class="mr-5 white-txt">Admin panel</a>
                {/if}
                {#if $userData.logged && !isStuff}
                    <a href="#/panel" class="mr-5 white-txt">Client panel</a>
                {/if}
            </nav>
            <div class="flex-1 flex items-center justify-end">
                {#if $userData.logged}
                    <p class="white-txt">Hi {$userData.user.login}</p>
                    <button
                        class="m-1 hover:bg-accent hover:text-black p-1"
                        on:click={logout}>Logout</button
                    >
                {/if}
            </div>
        </div>
    </header>
</main>

<style>
    .white-txt {
        @apply text-white;
    }
    .nohover {
        @apply hover:no-underline;
    }
</style>
