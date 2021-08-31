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
 * @Title("MC-22025: Gender attribute blank value is saved in direct edits from customer grid")
 * @Description("Check that gender attribute blank value can be saved on customers grid<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminChangeCustomerGenderInCustomersGridTest.xml<br>")
 * @TestCaseId("MC-22025")
 * @group customer
 */
class AdminChangeCustomerGenderInCustomersGridTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Reset customer grid filter");
		$I->comment("Entering Action Group [goToCustomersGridPage] AdminOpenCustomersGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomersGridPageGoToCustomersGridPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToCustomersGridPage
		$I->comment("Exiting Action Group [goToCustomersGridPage] AdminOpenCustomersGridActionGroup");
		$I->comment("Entering Action Group [resetFilter] AdminResetFilterInCustomerGrid");
		$I->conditionalClick(".admin__data-grid-header .action-tertiary.action-clear", ".admin__data-grid-header .action-tertiary.action-clear", true); // stepKey: clickClearFiltersResetFilter
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetFilterWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetFilter
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetFilter
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetFilterWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadResetFilter
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetFilter
		$I->comment("Exiting Action Group [resetFilter] AdminResetFilterInCustomerGrid");
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
	 * @Stories({"Update Customer"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminChangeCustomerGenderInCustomersGridTest(AcceptanceTester $I)
	{
		$I->comment("Open customers grid page, filter by created customer");
		$I->comment("Entering Action Group [filterCustomerGridByEmail] AdminFilterCustomerByEmail");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomerIndexPageFilterCustomerGridByEmail
		$I->waitForPageLoad(30); // stepKey: waitToCustomerIndexPageToLoadFilterCustomerGridByEmail
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomerIndexPageFilterCustomerGridByEmail
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomerIndexPageFilterCustomerGridByEmailWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetFilterCustomerGridByEmail
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetFilterCustomerGridByEmailWaitForPageLoad
		$I->fillField("input[name=email]", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailFilterCustomerGridByEmail
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterFilterCustomerGridByEmail
		$I->waitForPageLoad(30); // stepKey: applyFilterFilterCustomerGridByEmailWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFilterCustomerGridByEmail
		$I->comment("Exiting Action Group [filterCustomerGridByEmail] AdminFilterCustomerByEmail");
		$I->comment("Check customer is in grid");
		$I->comment("Entering Action Group [assertCustomerInCustomersGrid] AdminAssertCustomerInCustomersGrid");
		$I->see($I->retrieveEntityField('createCustomer', 'email', 'test'), "//*[@data-role='sticky-el-root']/parent::div/parent::div/following-sibling::div//tbody//*[@class='data-row'][1]"); // stepKey: seeCustomerInGridAssertCustomerInCustomersGrid
		$I->comment("Exiting Action Group [assertCustomerInCustomersGrid] AdminAssertCustomerInCustomersGrid");
		$I->comment("Check customer Gender value in grid");
		$I->comment("Entering Action Group [assertCustomerGenderInCustomersGrid] AssertAdminCustomerGenderInCustomersGridActionGroup");
		$I->see("", "//tr[@class='data-row']//div[text()='" . $I->retrieveEntityField('createCustomer', 'email', 'test') . "']/ancestor::tr/td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Gender')]/preceding-sibling::th) +1]"); // stepKey: assertGenderValueAssertCustomerGenderInCustomersGrid
		$I->comment("Exiting Action Group [assertCustomerGenderInCustomersGrid] AssertAdminCustomerGenderInCustomersGridActionGroup");
		$I->comment("Update customer Gender to Male");
		$I->comment("Entering Action Group [updateCustomerGenderWithMaleValueInCustomersGrid] AdminUpdateCustomerGenderInCustomersGridActionGroup");
		$I->click("//tbody/tr[td[*[contains(.,normalize-space('" . $I->retrieveEntityField('createCustomer', 'email', 'test') . "'))]]]"); // stepKey: clickCustomersGridRowUpdateCustomerGenderWithMaleValueInCustomersGrid
		$I->waitForPageLoad(30); // stepKey: clickCustomersGridRowUpdateCustomerGenderWithMaleValueInCustomersGridWaitForPageLoad
		$I->waitForElementVisible("tr.data-grid-editable-row:not([style*='display: none']) [name='gender']", 30); // stepKey: waitForGenderElementAppearsUpdateCustomerGenderWithMaleValueInCustomersGrid
		$I->selectOption("tr.data-grid-editable-row:not([style*='display: none']) [name='gender']", "Male"); // stepKey: selectGenderValueUpdateCustomerGenderWithMaleValueInCustomersGrid
		$I->click("tr.data-grid-editable-row-actions button.action-primary"); // stepKey: saveCustomerUpdateCustomerGenderWithMaleValueInCustomersGrid
		$I->waitForPageLoad(30); // stepKey: saveCustomerUpdateCustomerGenderWithMaleValueInCustomersGridWaitForPageLoad
		$I->comment("Exiting Action Group [updateCustomerGenderWithMaleValueInCustomersGrid] AdminUpdateCustomerGenderInCustomersGridActionGroup");
		$I->comment("Check customer Gender value in grid");
		$I->comment("Entering Action Group [assertCustomerGenderMaleInCustomersGrid] AssertAdminCustomerGenderInCustomersGridActionGroup");
		$I->see("Male", "//tr[@class='data-row']//div[text()='" . $I->retrieveEntityField('createCustomer', 'email', 'test') . "']/ancestor::tr/td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Gender')]/preceding-sibling::th) +1]"); // stepKey: assertGenderValueAssertCustomerGenderMaleInCustomersGrid
		$I->comment("Exiting Action Group [assertCustomerGenderMaleInCustomersGrid] AssertAdminCustomerGenderInCustomersGridActionGroup");
		$I->comment("Open customer edit page and check Gender value");
		$I->comment("Entering Action Group [openCustomerEditPageWithMaleGender] AdminOpenCustomerEditPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createCustomer', 'id', 'test')); // stepKey: openCustomerEditPageOpenCustomerEditPageWithMaleGender
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCustomerEditPageWithMaleGender
		$I->comment("Exiting Action Group [openCustomerEditPageWithMaleGender] AdminOpenCustomerEditPageActionGroup");
		$I->comment("Entering Action Group [assertCustomerGenderValueIsMaleOnCustomerForm] AssertAdminCustomerGenderOnCustomerFormActionGroup");
		$I->conditionalClick("#tab_customer", "//select[contains(@name, 'customer[gender]')]", false); // stepKey: clickOnAccountInfoTabAssertCustomerGenderValueIsMaleOnCustomerForm
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertCustomerGenderValueIsMaleOnCustomerForm
		$I->seeOptionIsSelected("//select[contains(@name, 'customer[gender]')]", "Male"); // stepKey: verifyNeededCustomerGenderSelectedAssertCustomerGenderValueIsMaleOnCustomerForm
		$I->comment("Exiting Action Group [assertCustomerGenderValueIsMaleOnCustomerForm] AssertAdminCustomerGenderOnCustomerFormActionGroup");
		$I->comment("Filter customers grid by email");
		$I->comment("Entering Action Group [filterCustomerByEmailToUpdateWithEmptyGender] AdminFilterCustomerByEmail");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomerIndexPageFilterCustomerByEmailToUpdateWithEmptyGender
		$I->waitForPageLoad(30); // stepKey: waitToCustomerIndexPageToLoadFilterCustomerByEmailToUpdateWithEmptyGender
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomerIndexPageFilterCustomerByEmailToUpdateWithEmptyGender
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomerIndexPageFilterCustomerByEmailToUpdateWithEmptyGenderWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetFilterCustomerByEmailToUpdateWithEmptyGender
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetFilterCustomerByEmailToUpdateWithEmptyGenderWaitForPageLoad
		$I->fillField("input[name=email]", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailFilterCustomerByEmailToUpdateWithEmptyGender
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterFilterCustomerByEmailToUpdateWithEmptyGender
		$I->waitForPageLoad(30); // stepKey: applyFilterFilterCustomerByEmailToUpdateWithEmptyGenderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFilterCustomerByEmailToUpdateWithEmptyGender
		$I->comment("Exiting Action Group [filterCustomerByEmailToUpdateWithEmptyGender] AdminFilterCustomerByEmail");
		$I->comment("Update customer Gender to empty value");
		$I->comment("Entering Action Group [updateCustomerGenderWithEmptyValueInCustomersGrid] AdminUpdateCustomerGenderInCustomersGridActionGroup");
		$I->click("//tbody/tr[td[*[contains(.,normalize-space('" . $I->retrieveEntityField('createCustomer', 'email', 'test') . "'))]]]"); // stepKey: clickCustomersGridRowUpdateCustomerGenderWithEmptyValueInCustomersGrid
		$I->waitForPageLoad(30); // stepKey: clickCustomersGridRowUpdateCustomerGenderWithEmptyValueInCustomersGridWaitForPageLoad
		$I->waitForElementVisible("tr.data-grid-editable-row:not([style*='display: none']) [name='gender']", 30); // stepKey: waitForGenderElementAppearsUpdateCustomerGenderWithEmptyValueInCustomersGrid
		$I->selectOption("tr.data-grid-editable-row:not([style*='display: none']) [name='gender']", ""); // stepKey: selectGenderValueUpdateCustomerGenderWithEmptyValueInCustomersGrid
		$I->click("tr.data-grid-editable-row-actions button.action-primary"); // stepKey: saveCustomerUpdateCustomerGenderWithEmptyValueInCustomersGrid
		$I->waitForPageLoad(30); // stepKey: saveCustomerUpdateCustomerGenderWithEmptyValueInCustomersGridWaitForPageLoad
		$I->comment("Exiting Action Group [updateCustomerGenderWithEmptyValueInCustomersGrid] AdminUpdateCustomerGenderInCustomersGridActionGroup");
		$I->comment("Check customer Gender value in grid");
		$I->comment("Entering Action Group [assertCustomerGenderEmptyInCustomersGrid] AssertAdminCustomerGenderInCustomersGridActionGroup");
		$I->see("", "//tr[@class='data-row']//div[text()='" . $I->retrieveEntityField('createCustomer', 'email', 'test') . "']/ancestor::tr/td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Gender')]/preceding-sibling::th) +1]"); // stepKey: assertGenderValueAssertCustomerGenderEmptyInCustomersGrid
		$I->comment("Exiting Action Group [assertCustomerGenderEmptyInCustomersGrid] AssertAdminCustomerGenderInCustomersGridActionGroup");
		$I->comment("Open customer edit page and check Gender value");
		$I->comment("Entering Action Group [openCustomerEditPageWithEmptyGender] AdminOpenCustomerEditPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createCustomer', 'id', 'test')); // stepKey: openCustomerEditPageOpenCustomerEditPageWithEmptyGender
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCustomerEditPageWithEmptyGender
		$I->comment("Exiting Action Group [openCustomerEditPageWithEmptyGender] AdminOpenCustomerEditPageActionGroup");
		$I->comment("Entering Action Group [assertCustomerGenderValueIsEmptyOnCustomerForm] AssertAdminCustomerGenderOnCustomerFormActionGroup");
		$I->conditionalClick("#tab_customer", "//select[contains(@name, 'customer[gender]')]", false); // stepKey: clickOnAccountInfoTabAssertCustomerGenderValueIsEmptyOnCustomerForm
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertCustomerGenderValueIsEmptyOnCustomerForm
		$I->seeOptionIsSelected("//select[contains(@name, 'customer[gender]')]", ""); // stepKey: verifyNeededCustomerGenderSelectedAssertCustomerGenderValueIsEmptyOnCustomerForm
		$I->comment("Exiting Action Group [assertCustomerGenderValueIsEmptyOnCustomerForm] AssertAdminCustomerGenderOnCustomerFormActionGroup");
	}
}
