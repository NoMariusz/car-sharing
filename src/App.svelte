<script>
    import Tailwindcss from "./Tailwindcss.svelte";
    import Router from "svelte-spa-router";
    import Home from "./components/Home.svelte";
    import NotFound from "./components/common/NotFound.svelte";
    import Header from "./components/common/Header.svelte";
    import Register from "./components/Register.svelte";
    import Login from "./components/Login.svelte";

    import { updateUserData } from "./utils";

    updateUserData();

    export let name;
</script>

<Tailwindcss />
<Header />
<main>
    <Router
        routes={{
            "/": Home,
            "/home": Home,
            "/register": Register,
            "/login": Login,
            "*": NotFound,
        }}
    />
</main>

<style>
    main {
        text-align: center;
        padding: 1em;
        max-width: 480px;
        margin: 0 auto;
    }

    @media (min-width: 640px) {
        main {
            max-width: none;
        }
    }
</style>
