<script>
    import Tailwindcss from "./Tailwindcss.svelte";
    import Router from "svelte-spa-router";
    import Home from "./home/Home.svelte";
    import NotFound from "./common/NotFound.svelte";
    import Header from "./common/Header.svelte";

    export let name;
</script>

<Tailwindcss />
<Header />
<main>
    <Router
        routes={{
            "/": Home,
            "/home": Home,
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
