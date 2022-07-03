
    const link = document.querySelector('#season-link');

    document.getElementById("season-select").addEventListener( "change", function(e)
    {
        const t = e.target.value;

        link.href = "/season/" + t;
        if (e.target.value === '') {
            link.classList.add("disabled");
        } else {
            link.classList.remove("disabled");
        }
    });

   
