<script>
    import { userData } from "../../stores";
    import { checkIfStuffMember } from "../../utils";
    import AdminReservationsBlock from "./AdminReservationsBlock.svelte";

    import UsersBlock from "./UsersBlock.svelte";

    let isStuff = false;
    userData.subscribe((v) => {
        isStuff = checkIfStuffMember();
    });
</script>

<div class="flex justify-center flex-col">
    {#if isStuff}
        <h1 class="text-5xl m-5 text-center">Admin Panel</h1>
        <UsersBlock />
        <AdminReservationsBlock />
    {:else}
        <h1 class="text-5xl m-5 text-center">Access denied</h1>
    {/if}
</div>
