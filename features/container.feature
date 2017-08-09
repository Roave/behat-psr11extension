Feature:

  Scenario:
    Given I have a Zend\ServiceManager container
    When I instantiate a context
    Then I should have services injected
