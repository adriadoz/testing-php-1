Feature: Get Physical Attributes Pokemon
  In order to get pysical attributes from a Pokemon
  As an api user
  I want to get the height and weight of some Pokemon

  Scenario: when pokemon do not exist
    Given I do a "GET" request to "/pokemon/5438789879"
    Then the response code should be "404"

  Scenario: when pokemon exist
    Given I do a "GET" request to "/pokemon/2"
    Then the response code should be "200"
    And  the response should be:
    """
    {"name":"voltorb","weight":5,"height":12}
    """