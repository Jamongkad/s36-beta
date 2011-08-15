ko.bindingHandlers.clicky = {
    init: function(element, valueAccessor) {
        $(element).bind("click", function() {
            //$(this).fadeOut();
            console.log(valueAccessor());
            $(this).parents('.feeds').fadeOut();
        }); 
    }
};

function feedback(text, feed_id, ownerViewModel) {
    this.text = text;
    this.feed_id = feed_id;
    this.owner = ownerViewModel;
    this.remove = function() { ownerViewModel.feeds.remove(this) } 
}

function feedbackListViewModel() {
    this.feeds = ko.observableArray([]);
    var self = this;
    $.ajax({
        url: "/index.php/feedback/samplefeeds"
      , dataType: "json"
      , success: function(msg) {
            var mappedFeeds = $.map(msg, function(item) {
                return new feedback(item.text, item.id, self);
            });
            self.feeds(mappedFeeds);
        }
    });
}

ko.applyBindings(new feedbackListViewModel()); 
/*
var meals = [
    { mealName: "Standard (sandwich)", price: 0}
  , { mealName: "Premium (sandwich)", price: 34.95}
  , { mealName: "Ultimate (sandwich)", price: 209.34}
];

var Seats = function(name) {
    this.name = name;    
    this.availableMeals = meals;
    this.meal = ko.observable(meals[0]);
    this.formattedPrice = ko.dependentObservable(function() {
        var price = this.meal().price;
        return price ? "$" + price.toFixed(2) : "None";
    }, this);

    this.remove = function() {
        viewModel.seats.remove(this);
    };
}

var viewModel = {
      shouldShowMessage: ko.observable("Mathew D. Wong")
    , showMessage: ko.observableArray([])
    , numberOfClicks: ko.observable(0) 
    , incrementClickCounter: function() {
         var previousCounter = this.numberOfClicks();  
         this.numberOfClicks(previousCounter + 1);
    }
    , firstName: ko.observable("Bert") 
    , lastName: ko.observable("Otting")
    , capitalizeLastName: function() {
         var currentLast = this.lastName();
         this.lastName(currentLast.toUpperCase());
    }
    , seats: ko.observableArray([
         new Seats("Mathew")
       , new Seats("Kat")
    ])
    , addSeats: function() {
        this.seats.push(new Seats());
    }
};

viewModel.fullName = ko.dependentObservable(function() {
    return this.firstName() + " " + this.lastName();
}, viewModel);

viewModel.totalSurchage = ko.dependentObservable(function() {
   var total = 0; 
   for(var i=0; i < this.seats().length; i++) {
       total += this.seats()[i].meal().price;
   }
   return total;
}, viewModel);

ko.applyBindings(viewModel); 
*/
