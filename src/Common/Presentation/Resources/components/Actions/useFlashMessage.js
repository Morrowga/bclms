import { SuccessDialog } from "@actions/useSuccess";

let FlashMessage = ({flash}) => {
    let success = flash?.value?.successMessage;

    if(success !== null)
                    {
        SuccessDialog({ title: success });
    }else{
        SuccessDialog({
            title: flash?.value?.errorMessage,
            mainTitle: "Error!",
            color: "#ff6262",
            icon: "error",
        });
    }

};
export { FlashMessage };
