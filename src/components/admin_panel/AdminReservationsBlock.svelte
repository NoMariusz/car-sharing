<script>
    import { API_PATH, RESERVATION_STATUSES } from "../../constants";

    const loadReservations = async () => {
        const res = await fetch(`${API_PATH}public/getAllReservations.php`);
        const d = await res.json();
        if (d.success) {
            reservations = [...d.data];
        }
    };
    let reservations = [];
    loadReservations();

    const reservationStatusesNames = Object.keys(RESERVATION_STATUSES);

    const updateReservation = (reservation) => {
        console.log(reservation);
    };
</script>

<div class="flex justify-center items-center">
    <section class="text-gray-600 body-font w-full">
        <div class="py-24 w-full mx-auto">
            <div class="flex flex-col text-center w-full mb-20">
                <h1
                    class="sm:text-3xl text-2xl font-medium   mb-4 text-gray-900"
                >
                    Reservations
                </h1>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base">
                    Show, change reservation status, change reservation dates
                </p>
            </div>
            <div class="flex flex-wrap w-auto ">
                <div class="w-auto overflow-auto mx-auto">
                    <table
                        class="table-auto w-full text-left whitespace-no-wrap"
                    >
                        <thead>
                            <tr>
                                <th class="th-style rounded-tl rounded-bl"
                                    >Id</th
                                >
                                <th class="th-style">Status</th>
                                <th class="th-style">Car id</th>
                                <th class="th-style">Car data</th>
                                <th class="th-style">User Id</th>
                                <th class="th-style">Login</th>
                                <th class="th-style">Reputation</th>
                                <th class="th-style">Start date</th>
                                <th class="th-style">End date</th>
                                <th class="th-style">Return date</th>
                                <th class="th-blank" />
                            </tr>
                        </thead>
                        <tbody>
                            {#each reservations as res}
                                <tr
                                    class={`${
                                        res.cancelled == "1" ? "bg-red-50" : ""
                                    } rounded`}
                                >
                                    <td class="td-p">{res.id}</td>
                                    <td class="td-pd text-lg text-gray-900">
                                        <select
                                            name="role"
                                            id="role"
                                            bind:value={res.reservation_status_id}
                                            disabled={res.cancelled == "1"}
                                        >
                                            {#each reservationStatusesNames as status_name}
                                                <option
                                                    value={RESERVATION_STATUSES[
                                                        status_name
                                                    ]}>{status_name}</option
                                                >
                                            {/each}
                                        </select>
                                    </td>
                                    <td class="td-pd">{res.car_id}</td>
                                    <td class="td-pd">
                                        <div
                                            class="w-5 h-5 shadow-md rounded-full mr-2"
                                            style={`background-color: ${res.color}`}
                                        />
                                        <p>{res.mark} {res.model} {res.year}</p>
                                    </td>
                                    <td class="td-pd">{res.user_id}</td>
                                    <td class="td-pd">{res.login}</td>
                                    <td class="td-pd ">{res.reputation}</td>
                                    <td class="td-pd ">
                                        <input
                                            type="datetime-local"
                                            name="sdt"
                                            class="dt-input"
                                            id="sdt"
                                            bind:value={res.start_date}
                                        />
                                    </td>
                                    <td class="td-pd ">
                                        <input
                                            type="datetime-local"
                                            name="sdt"
                                            lass="dt-input"
                                            id="sdt"
                                            bind:value={res.end_date}
                                        />
                                    </td>
                                    <td class="td-pd ">
                                        <input
                                            type="datetime-local"
                                            name="sdt"
                                            lass="dt-input"
                                            id="sdt"
                                            bind:value={res.return_date}
                                            disabled
                                        />
                                    </td>
                                    <td class="td-pd text-lg text-gray-900">
                                        {#if res.cancelled == "1"}
                                            <td class="td-pd"
                                                >Response was cancelled</td
                                            >
                                        {:else}
                                            <button
                                                on:click={updateReservation(
                                                    res
                                                )}
                                            >
                                                Save changes
                                            </button>
                                        {/if}
                                    </td>
                                </tr>
                            {/each}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .th-style {
        @apply td-pd   tracking-wider font-medium text-gray-900 text-sm bg-gray-100;
    }

    .th-blank {
        @apply w-10   tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br;
    }

    .td-pd {
        @apply px-2 py-1.5;
    }

    .dt-input {
        @apply text-sm;
    }
</style>
