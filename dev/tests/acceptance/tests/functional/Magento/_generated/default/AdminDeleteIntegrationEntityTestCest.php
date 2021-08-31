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
 * @Title("MC-28027: Admin system integration")
 * @Description("Admin Deletes Created Integration<h3>Test files</h3>app/code/Magento/Integration/Test/Mftf/Test/AdminDeleteIntegrationEntityTest.xml<br>")
 * @TestCaseId("MC-28027")
 * @group integration
 * @group mtf_migrated
 */
class AdminDeleteIntegrationEntityTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Login As Admin");
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->comment("Navigate To Integrations Page");
		$I->comment("Entering Action Group [navigateToIntegrationsPage] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadNavigateToIntegrationsPage
		$I->click("li[data-ui-id='menu-magento-backend-system']"); // stepKey: clickOnMenuItemNavigateToIntegrationsPage
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemNavigateToIntegrationsPageWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-integration-system-integrations']"); // stepKey: clickOnSubmenuItemNavigateToIntegrationsPage
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemNavigateToIntegrationsPageWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToIntegrationsPage] AdminNavigateMenuActionGroup");
		$I->comment("Click the \"Add New Integration\" button");
		$I->comment("Entering Action Group [clickAddNewIntegrationButton] AdminNavigateToCreateIntegrationPageActionGroup");
		$I->click(".page-actions .add"); // stepKey: clickAddNewIntegrationButtonClickAddNewIntegrationButton
		$I->waitForPageLoad(30); // stepKey: waitForNewNIntegrationPageLoadedClickAddNewIntegrationButton
		$I->comment("Exiting Action Group [clickAddNewIntegrationButton] AdminNavigateToCreateIntegrationPageActionGroup");
		$I->comment("Create New Integration");
		$I->comment("Entering Action Group [createIntegration] AdminCreatesNewIntegrationActionGroup");
		$I->fillField("#integration_properties_name", msq("defaultIntegrationData") . " Integration"); // stepKey: fillNameFieldCreateIntegration
		$I->fillField("#integration_properties_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillAdminPasswordFieldCreateIntegration
		$I->comment("Exiting Action Group [createIntegration] AdminCreatesNewIntegrationActionGroup");
		$I->comment("Entering Action Group [submitTheForm] AdminSubmitNewIntegrationFormActionGroup");
		$I->comment("Click the \"Save\" Button");
		$I->click(".page-actions #save-split-button-button"); // stepKey: clickSaveButtonSubmitTheForm
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSubmitTheForm
		$I->comment("Exiting Action Group [submitTheForm] AdminSubmitNewIntegrationFormActionGroup");
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
	 * @Features({"Integration"})
	 * @Stories({"System Integration"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteIntegrationEntityTest(AcceptanceTester $I)
	{
		$I->comment("TEST BODY");
		$I->comment("Find Created Integration In Grid");
		$I->comment("Entering Action Group [findCreatedIntegration] AdminSearchIntegrationInGridActionGroup");
		$I->comment("Reset Search Filters");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFindCreatedIntegration
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFindCreatedIntegrationWaitForPageLoad
		$I->comment("Fill Integration Name Field");
		$I->fillField(".data-grid-filters #integrationGrid_filter_name", msq("defaultIntegrationData") . " Integration"); // stepKey: filterByNameFindCreatedIntegration
		$I->comment("Click \"Search\" Button");
		$I->click(".admin__filter-actions button[title=Search]"); // stepKey: doFilterFindCreatedIntegration
		$I->waitForPageLoad(30); // stepKey: waitForSitemapPageLoadedAfterFilteringFindCreatedIntegration
		$I->comment("Exiting Action Group [findCreatedIntegration] AdminSearchIntegrationInGridActionGroup");
		$I->comment("Delete Created Integration Entity");
		$I->comment("Entering Action Group [deleteIntegration] AdminDeleteIntegrationEntityActionGroup");
		$I->click(".data-grid .delete"); // stepKey: clickRemoveButonDeleteIntegration
		$I->waitForElementVisible(".action-primary.action-accept", 30); // stepKey: waitForConfirmButtonVisibleDeleteIntegration
		$I->waitForPageLoad(30); // stepKey: waitForConfirmButtonVisibleDeleteIntegrationWaitForPageLoad
		$I->click(".action-primary.action-accept"); // stepKey: clickSubmitButtonDeleteIntegration
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonDeleteIntegrationWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteIntegration
		$I->comment("Exiting Action Group [deleteIntegration] AdminDeleteIntegrationEntityActionGroup");
		$I->comment("Assert Success Message");
		$I->comment("Entering Action Group [seeSuccessMessage] AssertAdminMessageCreateIntegrationEntityActionGroup");
		$I->waitForElementVisible("#messages .message-success", 30); // stepKey: waitForMessageSeeSuccessMessage
		$I->see("The integration '" . msq("defaultIntegrationData") . " Integration' has been deleted.", "#messages .message-success"); // stepKey: verifyMessageSeeSuccessMessage
		$I->comment("Exiting Action Group [seeSuccessMessage] AssertAdminMessageCreateIntegrationEntityActionGroup");
		$I->comment("Assert Deleted Integration Is Not In Grid");
		$I->comment("Entering Action Group [findDeletedIntegration] AdminSearchIntegrationInGridActionGroup");
		$I->comment("Reset Search Filters");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFindDeletedIntegration
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFindDeletedIntegrationWaitForPageLoad
		$I->comment("Fill Integration Name Field");
		$I->fillField(".data-grid-filters #integrationGrid_filter_name", msq("defaultIntegrationData") . " Integration"); // stepKey: filterByNameFindDeletedIntegration
		$I->comment("Click \"Search\" Button");
		$I->click(".admin__filter-actions button[title=Search]"); // stepKey: doFilterFindDeletedIntegration
		$I->waitForPageLoad(30); // stepKey: waitForSitemapPageLoadedAfterFilteringFindDeletedIntegration
		$I->comment("Exiting Action Group [findDeletedIntegration] AdminSearchIntegrationInGridActionGroup");
		$I->comment("Entering Action Group [dontSeeIntegration] AssertDeletedIntegrationIsNotInGridActionGroup");
		$I->dontSee(msq("defaultIntegrationData") . " Integration", "tr[data-role='row']:nth-of-type(1)"); // stepKey: donSeeIntegrationDontSeeIntegration
		$I->waitForPageLoad(30); // stepKey: donSeeIntegrationDontSeeIntegrationWaitForPageLoad
		$I->comment("Exiting Action Group [dontSeeIntegration] AssertDeletedIntegrationIsNotInGridActionGroup");
		$I->comment("END TEST BODY");
	}
}
