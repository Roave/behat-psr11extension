Feature:

  Scenario:
    Given I have a Zend\ServiceManager container
    When I instantiate a context
    Then I should have services injected through the constructor
    And I should have services injected as step arguments
