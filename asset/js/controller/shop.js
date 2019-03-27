var myapp = angular.module("shopApp", []);
myapp.controller("shopController", function ($scope) {
    // Show item to the page
    $scope.products = products;
    // Get the select item
    var selectedItems = [];
    $scope.selectedItems = selectedItems;
    // Click select item event
    $scope.addToCart = function (product) {
        var existItem = {};
        // Check an exist item in the ShopCart
        angular.forEach($scope.selectedItems, function (item, index) {
            if (item.id === product.id) {
                existItem = item;
                return false;
            }
        });

        // If exist item ++
        if (existItem.id !== undefined) {
            existItem.quantity++;
        }
        // Else add to catch
        else {
            var cartItem = angular.copy(product);
            cartItem.quantity = 1;
            $scope.selectedItems.push(cartItem);
        }
    };

    // Remove item  from cart
    $scope.remove = function (cartItem) {
        var index = $scope.selectedItems.indexOf(cartItem);
        $scope.selectedItems.splice(index, 1);
    };

    $scope.getTotal = function () {
        var total = 0;
        angular.forEach($scope.selectedItems, function (item, index) {
            total += (item.price * item.quantity);
        })
        return total;
    }
});
var products = [
    { id: "1", type: "Cars", name: " Royal M04 carbon", price: "90", imageUrl: "./asset/img/cart/1.jpg" },
    { id: "2", type: "Cars", name: "Royal M03 helmet", price: "50", imageUrl: "./asset/img/cart/2.jpg" },
    { id: "3", type: "Placards", name: "Multi-price signage", price: "19.5", imageUrl: "./asset/img/cart/3.jpg" },
    { id: "4", type: "Placards", name: " A-warning signboard", price: "58", imageUrl: "./asset/img/cart/4.jpg" },
    { id: "5", type: "flags & paddles", name: "24\" Construction Flags", price: "6.45", imageUrl: "./asset/img/cart/5.jpg" },
    { id: "6", type: "flags & paddles", name: "36\" Sewn Checkered Airport Flag", price: "19.5", imageUrl: "./asset/img/cart/6.jpg" },
    { id: "7", type: "flags & paddles", name: "18\" STOP/SLOW Paddles", price: "21.95", imageUrl: "./asset/img/cart/7.jpg" },
    { id: "8", type: "flags & paddles", name: "Handheld Traffic Flags", price: "11.95", imageUrl: "./asset/img/cart/8.jpg" },
    { id: "9", type: "flags & paddles", name: "12\" Octagon + 10.5' Handle", price: "17.25", imageUrl: "./asset/img/cart/9.jpg" },
    { id: "10", type: "safety vest", name: "Lime Brilliant Series", price: "15.95", imageUrl: "./asset/img/cart/10.jpg" },
    { id: "11", type: "safety vest", name: "Economy Contrasting Class 2", price: "11.75", imageUrl: "./asset/img/cart/11.jpg" },
    { id: "12", type: "safety vest", name: " Safety Vest - Police", price: "32.95", imageUrl: "./asset/img/cart/12.jpg" },
    { id: "13", type: "safety vest", name: " Safety Vest - Police", price: "17.5", imageUrl: "./asset/img/cart/13.jpg" },
    { id: "14", type: "fsafety vest", name: " Surveyors Vest", price: "49.95", imageUrl: "./asset/img/cart/14.jpg" }
];