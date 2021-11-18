<script>
    import { CLIENT_ROLE } from "../../constants";

    import { userData } from "../../stores";
    import OffertsBlock from "./OffertsBlock.svelte";
</script>

<div class="flex justify-center flex-col">
    {#if $userData?.user?.role_id == CLIENT_ROLE}
        <h1 class="text-5xl m-5 text-center">Client Panel</h1>
        <OffertsBlock />
    {:else}
        <h1 class="text-5xl m-5 text-center">Access denied</h1>
    {/if}
</div>
