[<img src="https://cdn.rawgit.com/lutsen/lagan/master/lagan-logo.svg" width="100" alt="Lagan">](https://github.com/lutsen/lagan)

Lagan One-to-many Property Controller
=====================================

Controller for the Lagan one-to-many property.  
Lets the user define a one-to-many relation between two content objects.

The Onetomany property type controller enables a one-to-many relation between 2 Lagan models. The name of the property should be the name of the Lagan model this model can have a one-to-many relation with. For this to work properly the other model should have a many-to-one relation with this model. So in our example in the Lagan project the LaganHoverkraft model has a one-to-many relation with the LaganCrew model, and the LaganCrew model has a many-to-one relation with the LaganHoverkraft model.

To be used with [Lagan](https://github.com/lutsen/lagan). Lagan lets you create flexible content objects with a simple class, and manage them with a web interface.

Lagan is a project of [Lútsen Stellingwerff](http://lutsen.land/) from [HoverKraft](http://www.hoverkraft.nl/).