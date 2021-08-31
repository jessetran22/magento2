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
 * @Title("MC-19889: Admin System Integration With Duplicated Name")
 * @Description("Admin Creates New Integration With Duplicated Name<h3>Test files</h3>app/code/Magento/Integration/Test/Mftf/Test/AdminCreateIntegrationEntityWithDuplicatedNameTest.xml<br>")
 * @TestCaseId("MC-19889")
 * @group integration
 * @group mtf_migrated
 */
class AdminCreateIntegrationEntityWithDuplicatedNameTestCest
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
		$I->comment("Entering Action Group [returnToIntegrationsPage] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadReturnToIntegrationsPage
		$I->click("li[data-ui-id='menu-magento-backend-system']"); // stepKey: clickOnMenuItemReturnToIntegrationsPage
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemReturnToIntegrationsPageWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-integration-system-integrations']"); // stepKey: clickOnSubmenuItemReturnToIntegrationsPage
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemReturnToIntegrationsPageWaitForPageLoad
		$I->comment("Exiting Action Group [returnToIntegrationsPage] AdminNavigateMenuActionGroup");
		$I->comment("Entering Action Group [searchForIntegration] AdminSearchIntegrationInGridActionGroup");
		$I->comment("Reset Search Filters");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchForIntegration
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchForIntegrationWaitForPageLoad
		$I->comment("Fill Integration Name Field");
		$I->fillField(".data-grid-filters #integrationGrid_filter_name", msq("defaultIntegrationData") . " Integration"); // stepKey: filterByNameSearchForIntegration
		$I->comment("Click \"Search\" Button");
		$I->click(".admin__filter-actions button[title=Search]"); // stepKey: doFilterSearchForIntegration
		$I->waitForPageLoad(30); // stepKey: waitForSitemapPageLoadedAfterFilteringSearchForIntegration
		$I->comment("Exiting Action Group [searchForIntegration] AdminSearchIntegrationInGridActionGroup");
		$I->comment("Entering Action Group [deleteCreatedIntegration] AdminDeleteIntegrationEntityActionGroup");
		$I->click(".data-grid .delete"); // stepKey: clickRemoveButonDeleteCreatedIntegration
		$I->waitForElementVisible(".action-primary.action-accept", 30); // stepKey: waitForConfirmButtonVisibleDeleteCreatedIntegration
		$I->waitForPageLoad(30); // stepKey: waitForConfirmButtonVisibleDeleteCreatedIntegrationWaitForPageLoad
		$I->click(".action-primary.action-accept"); // stepKey: clickSubmitButtonDeleteCreatedIntegration
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonDeleteCreatedIntegrationWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteCreatedIntegration
		$I->comment("Exiting Action Group [deleteCreatedIntegration] AdminDeleteIntegrationEntityActionGroup");
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
	 * @Stories({"Creating System Integration With Duplicated Name"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateIntegrationEntityWithDuplicatedNameTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToIntegrationsPage] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadNavigateToIntegrationsPage
		$I->click("li[data-ui-id='menu-magento-backend-system']"); // stepKey: clickOnMenuItemNavigateToIntegrationsPage
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemNavigateToIntegrationsPageWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-integration-system-integrations']"); // stepKey: clickOnSubmenuItemNavigateToIntegrationsPage
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemNavigateToIntegrationsPageWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToIntegrationsPage] AdminNavigateMenuActionGroup");
		$I->comment("Entering Action Group [clickAddNewIntegrationButton] AdminNavigateToCreateIntegrationPageActionGroup");
		$I->click(".page-actions .add"); // stepKey: clickAddNewIntegrationButtonClickAddNewIntegrationButton
		$I->waitForPageLoad(30); // stepKey: waitForNewNIntegrationPageLoadedClickAddNewIntegrationButton
		$I->comment("Exiting Action Group [clickAddNewIntegrationButton] AdminNavigateToCreateIntegrationPageActionGroup");
		$I->comment("Entering Action Group [createNewIntegration] AdminCreatesNewIntegrationActionGroup");
		$I->fillField("#integration_properties_name", msq("defaultIntegrationData") . " Integration"); // stepKey: fillNameFieldCreateNewIntegration
		$I->fillField("#integration_properties_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillAdminPasswordFieldCreateNewIntegration
		$I->comment("Exiting Action Group [createNewIntegration] AdminCreatesNewIntegrationActionGroup");
		$I->comment("Entering Action Group [submitTheForm] AdminSubmitNewIntegrationFormActionGroup");
		$I->comment("Click the \"Save\" Button");
		$I->click(".page-actions #save-split-button-button"); // stepKey: clickSaveButtonSubmitTheForm
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSubmitTheForm
		$I->comment("Exiting Action Group [submitTheForm] AdminSubmitNewIntegrationFormActionGroup");
		$I->comment("Entering Action Group [clickAddNewIntegrationButtonSecondTime] AdminNavigateToCreateIntegrationPageActionGroup");
		$I->click(".page-actions .add"); // stepKey: clickAddNewIntegrationButtonClickAddNewIntegrationButtonSecondTime
		$I->waitForPageLoad(30); // stepKey: waitForNewNIntegrationPageLoadedClickAddNewIntegrationButtonSecondTime
		$I->comment("Exiting Action Group [clickAddNewIntegrationButtonSecondTime] AdminNavigateToCreateIntegrationPageActionGroup");
		$I->comment("Entering Action Group [createNewIntegrationWithDuplicatedName] AdminCreatesNewIntegrationActionGroup");
		$I->fillField("#integration_properties_name", msq("defaultIntegrationData") . " Integration"); // stepKey: fillNameFieldCreateNewIntegrationWithDuplicatedName
		$I->fillField("#integration_properties_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillAdminPasswordFieldCreateNewIntegrationWithDuplicatedName
		$I->comment("Exiting Action Group [createNewIntegrationWithDuplicatedName] AdminCreatesNewIntegrationActionGroup");
		$I->comment("Entering Action Group [submitTheFormWithDuplicatedName] AdminSubmitNewIntegrationFormActionGroup");
		$I->comment("Click the \"Save\" Button");
		$I->click(".page-actions #save-split-button-button"); // stepKey: clickSaveButtonSubmitTheFormWithDuplicatedName
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSubmitTheFormWithDuplicatedName
		$I->comment("Exiting Action Group [submitTheFormWithDuplicatedName] AdminSubmitNewIntegrationFormActionGroup");
		$I->comment("Entering Action Group [seeErrorMessage] AssertAdminMessageCreateIntegrationEntityActionGroup");
		$I->waitForElementVisible("#messages .message-error", 30); // stepKey: waitForMessageSeeErrorMessage
		$I->see("The integration with name \"" . msq("defaultIntegrationData") . " Integration\" exists.", "#messages .message-error"); // stepKey: verifyMessageSeeErrorMessage
		$I->comment("Exiting Action Group [seeErrorMessage] AssertAdminMessageCreateIntegrationEntityActionGroup");
		$I->comment("Entering Action Group [checkEnteredValueIsPreserved] AssertAdminIntegrationNameInFormActionGroup");
		$I->seeInField("#integration_properties_name", msq("defaultIntegrationData") . " Integration"); // stepKey: checkEnteredValueIsPreservedCheckEnteredValueIsPreserved
		$I->comment("Exiting Action Group [checkEnteredValueIsPreserved] AssertAdminIntegrationNameInFormActionGroup");
	}
}
