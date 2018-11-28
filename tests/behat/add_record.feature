@tool @tool_matt
Feature: Add and manage records in tool_matt
  As a teacher
  I want to add a record
  So that I can view the record later

  Background: Course with teacher and student exist.
    Given the following "users" exist:
      | username | firstname | lastname | email |
      | teacher1 | Teacher | 1 | teacher@asd.com |
      | student1 | Student | 1 | student@asd.com |
    And the following "courses" exist:
      | fullname | shortname |
      | Course 1 | C1 |
    And the following "course enrolments" exist:
      | user | course | role |
      | teacher1 | C1 | teacher |
      | student1 | C1 | student |

  @javascript
  Scenario: View the edit page
    Given I log in as "teacher1"
    And I am on "Course 1" course homepage
    And I navigate to "My nth Moodle plugin > View" in current page administration
    When I click on "Edit this entry" "link"
    Then the field "name" matches value ""

  @javascript
  Scenario: Add a record to the database
    Given I log in as "teacher1"
    And I am on "Course 1" course homepage
    And I navigate to "My nth Moodle plugin > View" in current page administration
    And I click on "Edit this entry" "link"
    And the field "name" matches value ""
    And I set the field "name" to "test"
    And I press "id_submitbutton"
    And I wait "10" seconds
    Then I should see "test" in the "generaltable" "table"

  @javascript
  Scenario: Add a record and then edit it
    Given I log in as "teacher1"
    And I am on "Course 1" course homepage
    And I navigate to "My nth Moodle plugin > View" in current page administration
    And I click on "Edit this entry" "link"
    And the field "name" matches value ""
    And I set the field "name" to "test"
    And I press "id_submitbutton"
    And I wait "10" seconds
    And I should see "test" in the "generaltable" "table"
    And I click on "Edit" "link"
    And the field "name" matches value "test"
    And I set the field "name" to "test2"
    And I press "id_submitbutton"
    And I wait "10" seconds
    Then I should see "test2" in the "generaltable" "table"
