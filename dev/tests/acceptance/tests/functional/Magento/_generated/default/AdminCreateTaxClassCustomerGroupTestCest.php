<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-5303: Create tax class customer group")
 * @Description("Create tax class customer group<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminCreateTaxClassCustomerGroupTest.xml<br>")
 * @TestCaseId("MC-5303")
 * @group customer
 * @group mtf_migrated
 */
class AdminCreateTaxClassCustomerGroupTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create Tax Class \"Customer tax class\"");
		$I->createEntity("createCustomerTaxClass", "hook", "customerTaxClass", [], []); // stepKey: createCustomerTaxClass
		$I->getEntity("customerTaxClassData", "hook", "customerTaxClass", ["createCustomerTaxClass"], null); // stepKey: customerTaxClassData
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteCustomerGroup] AdminDeleteCustomerGroupActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/group/"); // stepKey: goToAdminCustomerGroupIndexPageDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupIndexPageLoadDeleteCustomerGroup
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomerGroupIndexPageDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomerGroupIndexPageDeleteCustomerGroupWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetDeleteCustomerGroupWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='customer_group_code']", "Group-" . msq("CustomCustomerGroup")); // stepKey: fillNameFieldOnFiltersSectionDeleteCustomerGroup
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonDeleteCustomerGroupWaitForPageLoad
		$I->click("//div[text()='Group-" . msq("CustomCustomerGroup") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectButtonDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: clickSelectButtonDeleteCustomerGroupWaitForPageLoad
		$I->click("//div[text()='Group-" . msq("CustomCustomerGroup") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Delete']"); // stepKey: clickOnDeleteItemDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteItemDeleteCustomerGroupWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm div.modal-content", 30); // stepKey: waitForConfirmModalDeleteCustomerGroup
		$I->see("Are you sure you want to delete a Group-" . msq("CustomCustomerGroup") . " record?", ".modal-popup.confirm div.modal-content"); // stepKey: seeRemoveMessageDeleteCustomerGroup
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteCustomerGroupDeleteCustomerGroup
		$I->waitForPageLoad(60); // stepKey: confirmDeleteCustomerGroupDeleteCustomerGroupWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCustomerGroup
		$I->comment("Exiting Action Group [deleteCustomerGroup] AdminDeleteCustomerGroupActionGroup");
		$I->comment("Entering Action Group [clearFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilters] ClearFiltersAdminDataGridActionGroup");
		$I->deleteEntity("createCustomerTaxClass", "hook"); // stepKey: deleteCustomerTaxClass
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"Customer"})
	 * @Stories({"Create customer group"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateTaxClassCustomerGroupTest(AcceptanceTester $I)
	{
		$I->comment("Steps: 1. Log in to backend as admin user.
                    2. Navigate to Stores > Other Settings > Customer Groups.
                    3. Start to create new Customer Group.
                    4. Fill in all data according to data set:   Tax Class \"Customer tax class\"
                    5. Click \"Save Customer Group\" button.");
		$I->comment("Assert \"You saved the customer group.\" success message displayed");
		$I->comment("Assert created Customer Group displayed In Grid");
		$I->comment("Entering Action Group [createNewCustomerGroup] AdminCreateCustomerGroupActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/group/new/"); // stepKey: goToNewCustomerGroupPageCreateNewCustomerGroup
		$I->waitForPageLoad(30); // stepKey: waitForNewCustomerGroupPageLoadCreateNewCustomerGroup
		$I->comment("Set tax class for customer group");
		$I->fillField("#customer_group_code", "Group-" . msq("CustomCustomerGroup")); // stepKey: fillGroupNameCreateNewCustomerGroup
		$I->selectOption("#tax_class_id", $I->retrieveEntityField('customerTaxClassData', 'class_name', 'test')); // stepKey: selectTaxClassOptionCreateNewCustomerGroup
		$I->click("#save"); // stepKey: clickToSaveCustomerGroupCreateNewCustomerGroup
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupSavedCreateNewCustomerGroup
		$I->see("You saved the customer group."); // stepKey: seeCustomerGroupSaveMessageCreateNewCustomerGroup
		$I->comment("Exiting Action Group [createNewCustomerGroup] AdminCreateCustomerGroupActionGroup");
		$I->comment("Entering Action Group [assertCustomerGroupDisplayedInGrid] AdminAssertCustomerGroupPresentInGrid");
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomerGroupIndexPageAssertCustomerGroupDisplayedInGrid
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomerGroupIndexPageAssertCustomerGroupDisplayedInGridWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetAssertCustomerGroupDisplayedInGrid
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetAssertCustomerGroupDisplayedInGridWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='customer_group_code']", "Group-" . msq("CustomCustomerGroup")); // stepKey: fillNameFieldOnFiltersSectionAssertCustomerGroupDisplayedInGrid
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonAssertCustomerGroupDisplayedInGrid
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonAssertCustomerGroupDisplayedInGridWaitForPageLoad
		$I->see("Group-" . msq("CustomCustomerGroup"), "//tr//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Group')]/preceding-sibling::th) +1 ]"); // stepKey: seeCustomerGroupNameInGridAssertCustomerGroupDisplayedInGrid
		$I->comment("- Assume we are on admin customer group page.");
		$I->comment("Exiting Action Group [assertCustomerGroupDisplayedInGrid] AdminAssertCustomerGroupPresentInGrid");
		$I->comment("6. Go to Customers -> All Customers  -> click  \"Add New Customer\" button");
		$I->comment("Assert   created  Customer Group  displayed On Customer Form");
		$I->comment("Entering Action Group [assertCustomerGroupDisplayedOnCustomerForm] AdminAssertCustomerGroupOnCustomerForm");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/new"); // stepKey: amOnCustomerCreatePageAssertCustomerGroupDisplayedOnCustomerForm
		$I->waitForElementVisible("[name='customer[group_id]']", 30); // stepKey: waitForElementVisibleAssertCustomerGroupDisplayedOnCustomerForm
		$I->see("Group-" . msq("CustomCustomerGroup"), "[name='customer[group_id]']"); // stepKey: assertCustomerGroupPresentAssertCustomerGroupDisplayedOnCustomerForm
		$I->comment("Exiting Action Group [assertCustomerGroupDisplayedOnCustomerForm] AdminAssertCustomerGroupOnCustomerForm");
	}
}
