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
 * @Title("MC-14588: System Customer Groups")
 * @Description("Admin should not be able to delete system customer groups<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminCustomersDeleteSystemCustomerGroupTest.xml<br>")
 * @TestCaseId("MC-14588")
 * @group customers
 * @group mtf_migrated
 */
class AdminCustomersDeleteSystemCustomerGroupTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
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
	 * @Stories({"Delete System Customer Group"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCustomersDeleteSystemCustomerGroupTest(AcceptanceTester $I)
	{
		$I->comment("Verify Not Logged In customer group");
		$I->comment("Go to Customer Group grid page");
		$I->comment("Entering Action Group [openCustomerGroupGridPageToCheckNotLoggedInGroup] AdminOpenCustomerGroupsGridPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/group/"); // stepKey: goToAdminCustomerGroupIndexPageOpenCustomerGroupGridPageToCheckNotLoggedInGroup
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupIndexPageLoadOpenCustomerGroupGridPageToCheckNotLoggedInGroup
		$I->comment("Exiting Action Group [openCustomerGroupGridPageToCheckNotLoggedInGroup] AdminOpenCustomerGroupsGridPageActionGroup");
		$I->comment("Entering Action Group [filterCustomerGroupsByNotLoggedInGroup] AdminFilterCustomerGroupByNameActionGroup");
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomerGroupIndexPageFilterCustomerGroupsByNotLoggedInGroup
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomerGroupIndexPageFilterCustomerGroupsByNotLoggedInGroupWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetFilterCustomerGroupsByNotLoggedInGroup
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetFilterCustomerGroupsByNotLoggedInGroupWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='customer_group_code']", "NOT LOGGED IN"); // stepKey: fillNameFieldOnFiltersSectionFilterCustomerGroupsByNotLoggedInGroup
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonFilterCustomerGroupsByNotLoggedInGroup
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonFilterCustomerGroupsByNotLoggedInGroupWaitForPageLoad
		$I->comment("Exiting Action Group [filterCustomerGroupsByNotLoggedInGroup] AdminFilterCustomerGroupByNameActionGroup");
		$I->comment("Entering Action Group [openNotLoggedInCustomerGroupEditPage] AdminOpenCustomerGroupEditPageFromGridActionGroup");
		$I->conditionalClick("//button[@class='action-select']", "//button[@class='action-select']", true); // stepKey: clickSelectButtonOpenNotLoggedInCustomerGroupEditPage
		$I->click("//tr[.//td[count(//th[./*[.='Group']]/preceding-sibling::th) + 1][./*[.='NOT LOGGED IN']]]//a[contains(@href, '/edit/')]"); // stepKey: clickOnEditCustomerGroupOpenNotLoggedInCustomerGroupEditPage
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupEditPageOpenNotLoggedInCustomerGroupEditPage
		$I->comment("Exiting Action Group [openNotLoggedInCustomerGroupEditPage] AdminOpenCustomerGroupEditPageFromGridActionGroup");
		$I->comment("Entering Action Group [verifyThereIsNoDeleteButtonForNotLoggedInGroup] AssertDeleteCustomerGroupButtonMissingActionGroup");
		$I->dontSeeElement("AdminEditCustomerGroupSection.deleteButton"); // stepKey: dontSeeDeleteButtonVerifyThereIsNoDeleteButtonForNotLoggedInGroup
		$I->comment("Exiting Action Group [verifyThereIsNoDeleteButtonForNotLoggedInGroup] AssertDeleteCustomerGroupButtonMissingActionGroup");
		$I->comment("Verify General customer group");
		$I->comment("Go to Customer Group grid page");
		$I->comment("Entering Action Group [openCustomerGroupGridPageToCheckGeneralGroup] AdminOpenCustomerGroupsGridPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/group/"); // stepKey: goToAdminCustomerGroupIndexPageOpenCustomerGroupGridPageToCheckGeneralGroup
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupIndexPageLoadOpenCustomerGroupGridPageToCheckGeneralGroup
		$I->comment("Exiting Action Group [openCustomerGroupGridPageToCheckGeneralGroup] AdminOpenCustomerGroupsGridPageActionGroup");
		$I->comment("Entering Action Group [filterCustomerGroupsByGeneralGroup] AdminFilterCustomerGroupByNameActionGroup");
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomerGroupIndexPageFilterCustomerGroupsByGeneralGroup
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomerGroupIndexPageFilterCustomerGroupsByGeneralGroupWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetFilterCustomerGroupsByGeneralGroup
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetFilterCustomerGroupsByGeneralGroupWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='customer_group_code']", "General"); // stepKey: fillNameFieldOnFiltersSectionFilterCustomerGroupsByGeneralGroup
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonFilterCustomerGroupsByGeneralGroup
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonFilterCustomerGroupsByGeneralGroupWaitForPageLoad
		$I->comment("Exiting Action Group [filterCustomerGroupsByGeneralGroup] AdminFilterCustomerGroupByNameActionGroup");
		$I->comment("Entering Action Group [openGeneralCustomerGroupEditPage] AdminOpenCustomerGroupEditPageFromGridActionGroup");
		$I->conditionalClick("//button[@class='action-select']", "//button[@class='action-select']", true); // stepKey: clickSelectButtonOpenGeneralCustomerGroupEditPage
		$I->click("//tr[.//td[count(//th[./*[.='Group']]/preceding-sibling::th) + 1][./*[.='General']]]//a[contains(@href, '/edit/')]"); // stepKey: clickOnEditCustomerGroupOpenGeneralCustomerGroupEditPage
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupEditPageOpenGeneralCustomerGroupEditPage
		$I->comment("Exiting Action Group [openGeneralCustomerGroupEditPage] AdminOpenCustomerGroupEditPageFromGridActionGroup");
		$I->comment("Entering Action Group [verifyThereIsNoDeleteButtonForGeneralGroup] AssertDeleteCustomerGroupButtonMissingActionGroup");
		$I->dontSeeElement("AdminEditCustomerGroupSection.deleteButton"); // stepKey: dontSeeDeleteButtonVerifyThereIsNoDeleteButtonForGeneralGroup
		$I->comment("Exiting Action Group [verifyThereIsNoDeleteButtonForGeneralGroup] AssertDeleteCustomerGroupButtonMissingActionGroup");
	}
}
