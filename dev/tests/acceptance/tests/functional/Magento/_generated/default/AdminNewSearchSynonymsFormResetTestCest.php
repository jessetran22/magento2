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
 * @Title("MC-36382: Admin reset new search synonyms group form")
 * @Description("When admin users reset button on new search synonyms form all fields should be set to default values<h3>Test files</h3>app/code/Magento/Search/Test/Mftf/Test/AdminNewSearchSynonymsFormResetTest.xml<br>")
 * @TestCaseId("MC-36382")
 * @group Search
 */
class AdminNewSearchSynonymsFormResetTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
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
	 * @Features({"Search"})
	 * @Stories({"Reset new search synonyms group form"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminNewSearchSynonymsFormResetTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToSearchSynonymsPage] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadNavigateToSearchSynonymsPage
		$I->click("li[data-ui-id='menu-magento-backend-marketing']"); // stepKey: clickOnMenuItemNavigateToSearchSynonymsPage
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemNavigateToSearchSynonymsPageWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-search-search-synonyms']"); // stepKey: clickOnSubmenuItemNavigateToSearchSynonymsPage
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemNavigateToSearchSynonymsPageWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToSearchSynonymsPage] AdminNavigateMenuActionGroup");
		$I->comment("Entering Action Group [navigateToNewSearchSynonymsPage] AdminNavigateToNewSearchSynonymsPageActionGroup");
		$I->click(".page-actions-buttons #add"); // stepKey: clickNewSynonymsGroupButtonNavigateToNewSearchSynonymsPage
		$I->waitForPageLoad(30); // stepKey: waitForNewSearchSynonymsPageLoadedNavigateToNewSearchSynonymsPage
		$I->comment("Exiting Action Group [navigateToNewSearchSynonymsPage] AdminNavigateToNewSearchSynonymsPageActionGroup");
		$I->comment("Entering Action Group [fillNewSearchSynonyms] AdminFillNewSearchSynonymsActionGroup");
		$I->selectOption("//select[@name='scope_id']", "1:1"); // stepKey: selectScopeFillNewSearchSynonyms
		$I->fillField("//textarea[@name='synonyms']", "Test Synonyms"); // stepKey: fillSynonymsFillNewSearchSynonyms
		$I->checkOption("//input[@name='mergeOnConflict']"); // stepKey: checkCheckboxFillNewSearchSynonyms
		$I->comment("Exiting Action Group [fillNewSearchSynonyms] AdminFillNewSearchSynonymsActionGroup");
		$I->click("//button[@id='reset']"); // stepKey: clickResetButton
		$grabScopeValue = $I->grabValueFrom("//select[@name='scope_id']"); // stepKey: grabScopeValue
		$I->assertEquals("0:0", "$grabScopeValue"); // stepKey: assertScopeDefaultValue
		$grabSynonymsValue = $I->grabValueFrom("//textarea[@name='synonyms']"); // stepKey: grabSynonymsValue
		$I->assertEmpty("$grabSynonymsValue"); // stepKey: assertSynonymsDefaultValue
		$grabMergeValue = $I->grabValueFrom("//input[@name='mergeOnConflict']"); // stepKey: grabMergeValue
		$I->assertEquals("false", "$grabMergeValue"); // stepKey: assertMergeDefaultValue
	}
}
