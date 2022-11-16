<template>
    <div class="container">
        <section class="content">
            <div class="top_content">
                <div class="top_content_right">
                    <p class="dt_box">FIle</p>
                    <div class="container text-center mt-8">
                        <div class="row">
                            <div class="col">
                                <form
                                    @submit.prevent="submit"
                                    enctype="multipart/form-data"
                                >
                                    <input
                                        type="hidden"
                                        id="_token"
                                        value="{{ csrf_token() }}"
                                    />
                                    <div class="mb-3">
                                        <select
                                            v-model="form.type"
                                            class="form-control"
                                        >
                                            <option value="upload">
                                                Upload
                                            </option>
                                            <option value="path">Path</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <input
                                            type="text"
                                            v-model="form.file"
                                            class="form-control"
                                            placeholder="log.txt Inside public folder"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <input
                                            type="file"
                                            class="form-control"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <button
                                            class="form-control"
                                            type="submit"
                                            :disabled="form.processing"
                                            :class="{
                                                'opacity-25': form.processing,
                                            }"
                                        >
                                            Display Log File
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="responsive_table">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td width="250px">#</td>
                                <td width="250px">Log</td>
                                <td width="250px">Action</td>
                            </tr>
                        </thead>

                        <tr v-for="(item, index) in data" :key="item.id">
                            <td width="250px">{{ index }}</td>
                            <td width="250px">{{ item }}</td>
                            <td width="250px">Action</td>
                        </tr>
                    </table>
                    <div class="container text-center mt-8">
                        <div class="row">
                            <div class="col">
                                <tr v-for="item in pp" :key="item.id">
                                    Total :
                                    {{
                                        item.total
                                    }}
                                    Per Page :
                                    {{
                                        item.page
                                    }}
                                </tr>
                                <button
                                    type="button"
                                    class="btn btn-secondary m-4"
                                    style="background-color: rebeccapurple"
                                >
                                    &lt;&lceil;
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-secondary m-4"
                                    style="background-color: rebeccapurple"
                                >
                                    &lt;
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-secondary m-4"
                                    style="background-color: rebeccapurple"
                                >
                                    &gt;
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-secondary m-4"
                                    style="background-color: rebeccapurple"
                                >
                                    &lceil;&gt;
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- <tr v-for="n in item.count" :key="n">
                            <button type="button">  n </button>

                        </tr> -->
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { Inertia } from "@inertiajs/inertia";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    data: {
        type: Object,

        default: () => ({}),
    },
    pp: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    file: "",
    type: "",
});

const submit = () => {
    form.post(route("read"));
};
</script>
<style>
body {
    margin: 0;
    padding: 0;
    font-family: sans-serif;
    background-color: white;
}

header {
    min-height: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background: #3f51b5;
    position: fixed;
    left: 0;
    right: 0;
    top: 0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
}

header .btn_clear_all {
    background: #de4f4f;
}

header .name {
    font-size: 25px;
    font-weight: 500;
}

.content {
    margin-top: 65px;
    padding: 15px;
    min-height: 100px;
}

.content .date_selector {
    min-height: 26px;
    min-width: 130px;
    border-radius: 4px;
}

.top_content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.top_content .top_content_left {
    display: flex;
}

.top_content .top_content_left .log_filter {
    display: flex;
    align-items: center;
    margin-left: 15px;
}

.top_content .top_content_left .log_filter .log_type_item {
    margin-right: 4px;
    max-height: 20px;
    font-size: 11px;
    box-sizing: border-box;
    padding: 4px 6px;
    cursor: pointer;
}

.top_content .top_content_left .log_filter .log_type_item.active {
    background: #2f2e2f;
}

.top_content .top_content_left .log_filter .log_type_item.clear {
    background: #607d8b;
}

table {
    border-collapse: collapse;
    margin: 0;
    padding: 0;
    width: 100%;
}

table tr {
    padding: 5px;
}

table tr:hover {
}

thead tr td {
    background: #717171;
}

table th,
table td {
    padding: 5px;
    font-size: 14px;
    color: #666;
}

table th {
    font-size: 14px;
    letter-spacing: 1px;
    text-transform: uppercase;
}

@media screen and (max-width: 700px) {
    .top_content {
        flex-direction: column;
    }

    .top_content .top_content_left {
        flex-direction: column;
    }

    .top_content .log_filter {
        flex-wrap: wrap;
    }

    .top_content .log_filter .log_type_item {
        margin-bottom: 3px;
    }
}

@media screen and (max-width: 600px) {
    header {
        flex-direction: column;
    }

    header .name {
        margin-bottom: 20px;
    }

    .content {
        margin-top: 90px;
    }

    .btn {
        font-size: 13px;
    }

    .dt_box,
    .selected_date {
        text-align: center;
    }

    .responsive_table {
        max-width: 100%;
        overflow-x: auto;
    }

    table {
        border: 0;
    }

    table thead {
        display: none;
    }

    table tr {
        display: block;
        margin-bottom: 10px;
    }

    table td {
        display: block;
        font-size: 15px;
    }

    table td:last-child {
        border-bottom: 0;
    }

    table td:before {
        content: attr(data-label);
        float: left;
        font-weight: bold;
        text-transform: uppercase;
    }
}
</style>
