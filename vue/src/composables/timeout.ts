import { ref } from "vue"


export function useWrapTimeout() {
    let timeoutId = ref(null);
    const wrapFunc = (callback, delay) => {

        
       clearTimeout(timeoutId.value);
       timeoutId.value = setTimeout(()=>{
        callback();
       }, delay);
    }

    return { wrapFunc }
}

