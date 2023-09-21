import {ref} from "vue";
import { router } from "@inertiajs/core";
import axios from "axios";
let serverPage = ref();
let serverPerPage = ref(10);
let routeName = ref("");
let datas = ref([]);
//## initial state
let serverParams = ref({
    columnFilters: {},
    search: "",
    sort: {
        field: "",
        type: "",
    },
    page: 1,
    perPage: 10,
});



//## updateParams
let updateParams = (newProps) => {
    serverParams.value = Object.assign({}, serverParams.value, newProps);
};



//## page change on pagination
let onPageChange = () => {
    updateParams({ page: serverPage.value });
    loadItems();
};

//## perpage change selectbox
let onPerPageChange = (value) => {
    serverPage.value = 1;
    updateParams({ page: 1, perPage: value });
    loadItems();
};

//## watch per page change
watch(serverPerPage, function (value) {
    onPerPageChange(value);
});

//## filter folumn by name
let onColumnFilter = (params) => {
    updateParams(params);
    serverParams.value.page = 1;
    serverParams.value.search = "";
    loadItems();
};

//## query params to controller
let getQueryParams = () => {
    let data = {
        page: serverParams.value.page,
        perPage: serverParams.value.perPage,
        search: serverParams.value.search,
    };

    for (const [key, value] of Object.entries(
        serverParams.value.columnFilters
    )) {
        if (value) {
            data[key] = value;
        }
    }
    return data;
};

//## search items
let searchItems = () => {
    updateParams({ page: 1 });
    loadItems();
};

/****
 * load item everytime
 *
 */
let loadItems = async () => {
    await axios
        .get(route(routeName.value, getQueryParams()))
        .then((resp) => {
            datas.value = resp.data.data;
        });
};

//## truncatedText
let truncatedText = (text) => {
    if (text) {
        if (text?.length <= 30) {
            return text;
        } else {
            return text?.substring(0, 30) + "...";
        }
    }
};

export
{
    serverParams,
    updateParams,
    onColumnFilter,
    searchItems,
    truncatedText,
    loadItems,
    onPageChange,
    onPerPageChange,
    serverPage,
    serverPerPage,
    routeName,
    datas
}
