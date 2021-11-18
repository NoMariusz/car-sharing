<script>
    import { API_PATH, ID_TO_ROLE, ROLES_IDS } from "../../constants";

    const getUsers = async () => {
        const res = await fetch(`${API_PATH}public/getUsers.php`);
        const d = await res.json();
        if (d.success) {
            users = [
                ...d.data.map((e) => ({
                    ...e,
                    is_activated: e.is_activated == "1",
                })),
            ];
        }
    };
    let users = [];
    getUsers();

    const updateUser = async (user) => {
        console.log(user);
        const res = await fetch(
            `${API_PATH}public/updateUser.php?user_id=${user.user_id}&active=${
                user.is_activated ? "1" : "0"
            }&role_id=${user.role_id}`
        );
        const d = await res.json();
        console.log(d);
        if (!d.success) {
            alert(d.msg);
        }
    };
</script>

<div class="flex justify-center items-center p-2">
    <section class="text-gray-600 body-font w-full">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-20">
                <h1
                    class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900"
                >
                    All users
                </h1>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base">
                    You can activate, deactivate, or change role for users
                </p>
            </div>
            <div class="flex flex-wrap -m-2">
                <div class="lg:w-4/5 w-full mx-auto overflow-auto">
                    <table
                        class="table-auto w-full text-left whitespace-no-wrap"
                    >
                        <thead>
                            <tr>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"
                                    >user_id</th
                                >
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                    >login</th
                                >
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                    >email</th
                                >
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                    >reputation</th
                                >
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                    >role</th
                                >
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                    >active</th
                                >
                                <th
                                    class="w-10 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"
                                />
                            </tr>
                        </thead>
                        <tbody>
                            {#each users as user}
                                <tr>
                                    <td class="px-4 py-3">{user.user_id}</td>
                                    <td class="px-4 py-3">{user.login}</td>
                                    <td class="px-4 py-3">{user.email}</td>
                                    <td class="px-4 py-3">{user.reputation}</td>
                                    <td class="px-4 py-3 text-lg text-gray-900">
                                        <select
                                            name="role"
                                            id="role"
                                            bind:value={user.role_id}
                                        >
                                            {#each ROLES_IDS as role}
                                                <option value={role}
                                                    >{ID_TO_ROLE[role]}</option
                                                >
                                            {/each}
                                        </select>
                                    </td>
                                    <td class="w-10 text-center">
                                        <input
                                            name="plan"
                                            type="checkbox"
                                            bind:checked={user.is_activated}
                                        />
                                    </td>
                                    <td class="px-4 py-3 text-lg text-gray-900"
                                        ><button on:click={updateUser(user)}>
                                            Save changes
                                        </button>
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
