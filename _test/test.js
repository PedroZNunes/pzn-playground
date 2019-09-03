// REST 

function add ( ...numbers ) {
    if (numbers.length <= 0)
        return;

    let sum = numbers.reduce(( total, num ) =>  total + num );
    console.log( sum );
}

add(  );
add( 1 );
add( 1, 2, 4 );


//SPREAD

var arr1 = [3,4,5];
var arr2 = [1,2,...arr1,6,7,8];

console.log(arr2);
