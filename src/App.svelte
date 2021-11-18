<script context="module">
    import { checkIfStuffMember, updateUserData } from "./utils";
    updateUserData();
</script>

<script>
    import Tailwindcss from "./Tailwindcss.svelte";
    import Router from "svelte-spa-router";
    import Home from "./components/Home.svelte";
    import NotFound from "./components/common/NotFound.svelte";
    import Header from "./components/common/Header.svelte";
    import Register from "./components/Register.svelte";
    import Login from "./components/Login.svelte";

    import AdminPanel from "./components/admin_panel/AdminPanel.svelte";
    import { userData } from "./stores";

    export let name;

    let isStuffMember = false;
    userData.subscribe((v) => {
        isStuffMember = checkIfStuffMember();
    });
</script>

<Tailwindcss />
<Header isStuff={isStuffMember} />
<main>
    <Router
        routes={{
            "/": Home,
            "/home": Home,
            "/register": Register,
            "/login": Login,
            "/admin": AdminPanel,
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
