<script>
    import { API_PATH, CLIENT_ROLE } from "../../constants";

    import { userData } from "../../stores";
    import OffertsBlock from "./OffertsBlock.svelte";
    import ReservationsBlock from "./ReservationsBlock.svelte";

    const loadReservations = async () => {
        const res = await fetch(`${API_PATH}public/getReservations.php`);
        const d = await res.json();
        if (d.success) {
            reservations = [...d.data];
        }
    };
    let reservations = [];
    loadReservations();

    const loadOffers = async () => {
        const res = await fetch(`${API_PATH}public/getOffers.php`);
        const d = await res.json();
        if (d.success) {
            offers = [
                ...d.data.map((e) => ({
                    ...e,
                    is_reserved: parseInt(e.is_reserved),
                    reservations_count: parseInt(e.reservations_count),
                })),
            ];
        }
        console.log(offers);
    };
    let offers = [];
    loadOffers();

    const loadAll = () => {
        loadReservations();
        loadOffers();
    };
</script>

<div class="flex justify-center flex-col">
    {#if $userData?.user?.role_id == CLIENT_ROLE}
        <h1 class="text-5xl m-5 text-center">Client Panel</h1>
        <OffertsBlock {offers} {loadAll} />
        <ReservationsBlock {reservations} {loadAll} />
    {:else}
        <h1 class="text-5xl m-5 text-center">Access denied</h1>
    {/if}
</div>
