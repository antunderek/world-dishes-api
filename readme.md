## World Dishes Api 

Dishes of the world api.
Simple api that only gets a collection of requested data.

#### Used packages
[`fzaninotto/faker`](https://github.com/fzaninotto/Faker): PHP library that generates fake data<br>
[`jzonta/faker-restaurant`](https://github.com/jzonta/FakerRestaurant): Faker for Food and Beverage names generate<br>
[`Astrotomic/laravel-translatable`](https://github.com/Astrotomic/laravel-translatable): Laravel package for translatable models<br>

#### Database
![Database diagram](database_diagram.png)

#### Models
Models: `Category, Tag, Ingredient, Meal, Language`<br>
Translation models: `CategoryTranslation, TagTranslation, IngredientTranslation, MealTranslation`<br>
Pivot models: `MealTag, IngredientMeal`<br>

#### Classes
Custom classes are in `App/Utilities`.<br>
`FilterBuilder` - initialized in model with dynamic scope. Build filters based on namespace and filter data. Additional classes with queries are in folders of format `<Namespace>Filters` (example: `MealFilters`)<br>
`CustomMealFilters` - appends data to be called by `FilterBuilder`.<br>
`PaginateMeals` - handles pagination of meal data.<br>
`PrepareMealIndex` - calls all necessary actions to be called in `index` function of `ApiMealController`.<br>

#### Resources
Json resources: `CategoryResource, TagResource, IngredientResource, MealResource`<br>
Resource collection: `MealCollection`

#### Observers 
`MealTag, TagIngredient` - observe on deleting on pivot models, triggers on detach.<br>
`IngredientObserver, TagObserver` - observe on deleting, if connected meal data doesn't contain any tags or ingredients delete meal data.<br>
`MealObserver` - observe on update, restore. Check if meal contains ingredients or tags, if not delete meal data.

#### Controller
`ApiMealController` - contains `index` function that returns requested data.

#### Form Request Validation 
`MealsGetRequest` - handles validation for `index` function in `ApiMealController`.

#### Rules
Additional rules for form request validation with custom messages.<br>
`CategoryRegexRule, DiffTimeRegexRule, LanguageExistsRule, TagsRegexRule, WithAllowedRule`

#### Route
Declared in `api.php`<br>
`meals.index` - connected with `ApiMealController` uses function `index`.

#### Factories
`CategoryFactory, TagFactory, IngredientFactory`<br>
`MealFactory` - available states: `modified, deleted, category_null`.

#### Seeder
`LanguageSeeder` - seeds languages table with language and locale.

#### Example
`/api/meals?lang=en&diff_time=1493902343&category=null&with=category`
