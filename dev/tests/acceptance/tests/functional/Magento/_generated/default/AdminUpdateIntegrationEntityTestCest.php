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
 * @Title("MC-14398: Updating System Integration Entity")
 * @Description("Admin Updates Created Integration<h3>Test files</h3>app/code/Magento/Integration/Test/Mftf/Test/AdminUpdateIntegrationEntityTest.xml<br>")
 * @group integration
 * @group mtf_migrated
 * @TestCaseId("MC-14398")
 */
class AdminUpdateIntegrationEntityTestCest
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
		$I->fillField(".data-grid-filters #integrationGrid_filter_name", msq("defaultIntegrationData") . " Integration Updated"); // stepKey: filterByNameSearchForIntegration
		$I->comment("Click \"Search\" Button");
		$I->click(".admin__filter-actions button[title=Search]"); // stepKey: doFilterSearchForIntegration
		$I->waitForPageLoad(30); // stepKey: waitForSitemapPageLoadedAfterFilteringSearchForIntegration
		$I->comment("Exiting Action Group [searchForIntegration] AdminSearchIntegrationInGridActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	public function AdminUpdateIntegrationEntityTest(AcceptanceTester $I)
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
		$I->comment("Open Integration Edit Page");
		$I->comment("Entering Action Group [clickEditButton] AdminClickEditIntegrationEntityActionGroup");
		$I->click(".data-grid .edit"); // stepKey: clickEditButtonClickEditButton
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickEditButton
		$I->comment("Exiting Action Group [clickEditButton] AdminClickEditIntegrationEntityActionGroup");
		$I->comment("Update Integration Entity");
		$I->comment("Entering Action Group [updateIntegrationEntity] AdminUpdateCreatedIntegrationEntityActionGroup");
		$I->fillField("#integration_properties_name", msq("defaultIntegrationData") . " Integration Updated"); // stepKey: fillNameFieldUpdateIntegrationEntity
		$I->fillField("#integration_properties_endpoint", "https://endpoint-updated.com"); // stepKey: fillEndpiontFieldUpdateIntegrationEntity
		$I->fillField("#integration_properties_identity_link_url", "https://testlink-updated.com"); // stepKey: fillLinkUrlFieldUpdateIntegrationEntity
		$I->fillField("#integration_properties_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillAdminPasswordFieldUpdateIntegrationEntity
		$I->comment("Exiting Action Group [updateIntegrationEntity] AdminUpdateCreatedIntegrationEntityActionGroup");
		$I->comment("Submit The Form");
		$I->comment("Entering Action Group [submitTheForm] AdminSubmitIntegrationFormActionGroup");
		$I->comment("Click the \"Save\" Button");
		$I->click(".page-actions-buttons .save"); // stepKey: clickSaveButtonSubmitTheForm
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSubmitTheForm
		$I->comment("Exiting Action Group [submitTheForm] AdminSubmitIntegrationFormActionGroup");
		$I->comment("Assert Success Message");
		$I->comment("Entering Action Group [seeSuccessMessage] AssertAdminMessageCreateIntegrationEntityActionGroup");
		$I->waitForElementVisible("#messages .message-success", 30); // stepKey: waitForMessageSeeSuccessMessage
		$I->see("The integration '" . msq("defaultIntegrationData") . " Integration Updated' has been saved.", "#messages .message-success"); // stepKey: verifyMessageSeeSuccessMessage
		$I->comment("Exiting Action Group [seeSuccessMessage] AssertAdminMessageCreateIntegrationEntityActionGroup");
		$I->comment("Assert Updated Entity In Grid");
		$I->comment("Entering Action Group [findDeletedIntegration] AdminSearchIntegrationInGridActionGroup");
		$I->comment("Reset Search Filters");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFindDeletedIntegration
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFindDeletedIntegrationWaitForPageLoad
		$I->comment("Fill Integration Name Field");
		$I->fillField(".data-grid-filters #integrationGrid_filter_name", msq("defaultIntegrationData") . " Integration Updated"); // stepKey: filterByNameFindDeletedIntegration
		$I->comment("Click \"Search\" Button");
		$I->click(".admin__filter-actions button[title=Search]"); // stepKey: doFilterFindDeletedIntegration
		$I->waitForPageLoad(30); // stepKey: waitForSitemapPageLoadedAfterFilteringFindDeletedIntegration
		$I->comment("Exiting Action Group [findDeletedIntegration] AdminSearchIntegrationInGridActionGroup");
		$I->comment("Entering Action Group [seeIntegrationEntity] AssertUpdatedIntegrationEntityInGridActionGroup");
		$I->see(msq("defaultIntegrationData") . " Integration Updated", "tr[data-role='row']:nth-of-type(1)"); // stepKey: seeIntegrationEntitySeeIntegrationEntity
		$I->waitForPageLoad(30); // stepKey: seeIntegrationEntitySeeIntegrationEntityWaitForPageLoad
		$I->comment("Exiting Action Group [seeIntegrationEntity] AssertUpdatedIntegrationEntityInGridActionGroup");
	}
}
