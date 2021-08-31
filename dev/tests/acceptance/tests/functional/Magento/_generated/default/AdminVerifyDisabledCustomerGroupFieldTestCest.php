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
 * @Title("MC-14206: Check that field is disabled in system Customer Group")
 * @Description("Checks that customer_group_code field is disabled in NOT LOGGED IN Customer Group<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminVerifyDisabledCustomerGroupFieldTest.xml<br>")
 * @TestCaseId("MC-14206")
 * @group customers
 * @group mtf_migrated
 */
class AdminVerifyDisabledCustomerGroupFieldTestCest
{
	/**
	 * @Stories({"Check that field is disabled in system Customer Group"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Customer"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminVerifyDisabledCustomerGroupFieldTest(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [amOnCustomerGroupPage] AdminNavigateToCustomerGroupPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/group/"); // stepKey: openCustomersGridPageAmOnCustomerGroupPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAmOnCustomerGroupPage
		$I->comment("Exiting Action Group [amOnCustomerGroupPage] AdminNavigateToCustomerGroupPageActionGroup");
		$I->comment("Entering Action Group [clearFiltersIfTheySet] AdminFilterCustomerGroupByNameActionGroup");
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomerGroupIndexPageClearFiltersIfTheySet
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomerGroupIndexPageClearFiltersIfTheySetWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetClearFiltersIfTheySet
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetClearFiltersIfTheySetWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='customer_group_code']", "NOT LOGGED IN"); // stepKey: fillNameFieldOnFiltersSectionClearFiltersIfTheySet
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonClearFiltersIfTheySet
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonClearFiltersIfTheySetWaitForPageLoad
		$I->comment("Exiting Action Group [clearFiltersIfTheySet] AdminFilterCustomerGroupByNameActionGroup");
		$I->comment("Entering Action Group [openCustomerGroup] AdminGridCustomerGroupEditByCodeActionGroup");
		$I->click("//tr[.//td[count(//th[./*[.='Group']]/preceding-sibling::th) + 1][./*[.='NOT LOGGED IN']]]//a[contains(@href, '/edit/')]"); // stepKey: clickOnEditCustomerGroupOpenCustomerGroup
		$I->comment("Exiting Action Group [openCustomerGroup] AdminGridCustomerGroupEditByCodeActionGroup");
		$I->seeInField("#customer_group_code", "NOT LOGGED IN"); // stepKey: seeNotLoggedInTextInGroupName
		$I->assertElementContainsAttribute("#customer_group_code", "disabled", "true"); // stepKey: checkIfGroupNameIsDisabled
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
	}
}
