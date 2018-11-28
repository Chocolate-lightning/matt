@tool @tool_matt
Feature: Backup user data
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
  Scenario: Add a record to the database
    Given I log in as "teacher1"
    And I am on "Course 1" course homepage
    And I navigate to "My nth Moodle plugin > View" in current page administration
    When I press "Edit this entry"
    Then the field "name" matches value ""
    #Then "Quiz 1" row "Grade" column of "user-grade" table should contain "5"
    #And "Quiz 1" row "Percentage" column of "user-grade" table should contain "50"
