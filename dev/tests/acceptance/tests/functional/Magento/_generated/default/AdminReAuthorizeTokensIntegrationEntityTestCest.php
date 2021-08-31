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
 * @Title("MC-14397: Reauthorise Integration's Tokens")
 * @Description("ReAuthorising Tokens For Created Integration<h3>Test files</h3>app/code/Magento/Integration/Test/Mftf/Test/AdminReAuthorizeTokensIntegrationEntityTest.xml<br>")
 * @group integration
 * @group mtf_migrated
 * @TestCaseId("MC-14397")
 */
class AdminReAuthorizeTokensIntegrationEntityTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
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
		$I->comment("Entering Action Group [createIntegration] AdminFillIntegrationFormActionGroup");
		$I->fillField("#edit_form input[name='name']", msq("defaultIntegrationData") . " Integration"); // stepKey: fillIntegrationNameCreateIntegration
		$I->fillField("#edit_form input[name='current_password']", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillCurrentUserPasswordCreateIntegration
		$I->click("#integration_edit_tabs #integration_edit_tabs_api_section"); // stepKey: clickToOpenApiTabCreateIntegration
		$I->waitForPageLoad(30); // stepKey: waitForApiTabCreateIntegration
		$I->selectOption("[data-ui-id='integration-edit-tabs-tab-content-api-section'] [name='all_resources']", "All"); // stepKey: selectResourceAccessCreateIntegration
		$I->comment("TODO waiting for custom action functionality with MQE-1964");
		$I->comment("<performOn stepKey=\"checkNeededResources\" selector=\"\{\{AdminNewIntegrationFormSection.resourceTree\}\}\" function=\"function(\$I,\$apiResources=\{\{integration.resources\}\})\{foreach(\$apiResources as \$apiResource)\{\$I->conditionalClick('//li[@data-id=\'' . \$apiResource . '\']//*[@class=\'jstree-checkbox\']','//li[@data-id=\'' . \$apiResource . '\' and contains(@class, \'jstree-checked\')]',false);\}\}\" />");
		$I->comment("Exiting Action Group [createIntegration] AdminFillIntegrationFormActionGroup");
		$I->comment("Entering Action Group [clickSaveAndActivateButton] AdminIntegrationSaveAndActivateActionGroup");
		$I->click(".page-actions-buttons .action-toggle.primary"); // stepKey: clickIntegrationToggleClickSaveAndActivateButton
		$I->waitForElementVisible("#save-split-button-activate", 30); // stepKey: waitForSaveAndActivateButtonClickSaveAndActivateButton
		$I->click("#save-split-button-activate"); // stepKey: clickSaveAndActivateButtonClickSaveAndActivateButton
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickSaveAndActivateButton
		$I->comment("Exiting Action Group [clickSaveAndActivateButton] AdminIntegrationSaveAndActivateActionGroup");
		$I->comment("Entering Action Group [allowAccess] AdminAllowResourcesAccessIntegrationActionGroup");
		$I->click(".page-actions-buttons .action-primary"); // stepKey: clickAllowButtonAllowAccess
		$I->waitForPageLoad(30); // stepKey: waitForLoadingAllowAccess
		$I->comment("Exiting Action Group [allowAccess] AdminAllowResourcesAccessIntegrationActionGroup");
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
		$I->comment("Entering Action Group [searchForReAuthorizedIntegration] AdminSearchIntegrationInGridActionGroup");
		$I->comment("Reset Search Filters");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchForReAuthorizedIntegration
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchForReAuthorizedIntegrationWaitForPageLoad
		$I->comment("Fill Integration Name Field");
		$I->fillField(".data-grid-filters #integrationGrid_filter_name", msq("defaultIntegrationData") . " Integration"); // stepKey: filterByNameSearchForReAuthorizedIntegration
		$I->comment("Click \"Search\" Button");
		$I->click(".admin__filter-actions button[title=Search]"); // stepKey: doFilterSearchForReAuthorizedIntegration
		$I->waitForPageLoad(30); // stepKey: waitForSitemapPageLoadedAfterFilteringSearchForReAuthorizedIntegration
		$I->comment("Exiting Action Group [searchForReAuthorizedIntegration] AdminSearchIntegrationInGridActionGroup");
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
	 * @Stories({"System Integration"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminReAuthorizeTokensIntegrationEntityTest(AcceptanceTester $I)
	{
		$grabConsumerKey = $I->grabValueFrom(".admin__field-control.control #integration_token_consumer_key"); // stepKey: grabConsumerKey
		$grabConsumerSecret = $I->grabValueFrom(".admin__field-control.control #integration_token_consumer_secret"); // stepKey: grabConsumerSecret
		$grabAccessToken = $I->grabValueFrom(".admin__field-control.control #integration_token_token"); // stepKey: grabAccessToken
		$grabAccessTokenSecret = $I->grabValueFrom(".admin__field-control.control #integration_token_token_secret"); // stepKey: grabAccessTokenSecret
		$I->comment("Entering Action Group [clickDoneButton] AdminAllowResourcesAccessIntegrationActionGroup");
		$I->click(".page-actions-buttons .action-primary"); // stepKey: clickAllowButtonClickDoneButton
		$I->waitForPageLoad(30); // stepKey: waitForLoadingClickDoneButton
		$I->comment("Exiting Action Group [clickDoneButton] AdminAllowResourcesAccessIntegrationActionGroup");
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
		$I->comment("Entering Action Group [clickReauthoriseLink] AdminIntegrationClickReauthoriseLinkOnGridActionGroup");
		$I->click("#integrationGrid_table>tbody>tr:nth-child(1)>td.col-activate>a"); // stepKey: clickReauthoriseLinkClickReauthoriseLink
		$I->waitForPageLoad(30); // stepKey: waitForPopupLoadingClickReauthoriseLink
		$I->comment("Exiting Action Group [clickReauthoriseLink] AdminIntegrationClickReauthoriseLinkOnGridActionGroup");
		$I->comment("Entering Action Group [clickReauthoriseButton] AdminAllowResourcesAccessIntegrationActionGroup");
		$I->click(".page-actions-buttons .action-primary"); // stepKey: clickAllowButtonClickReauthoriseButton
		$I->waitForPageLoad(30); // stepKey: waitForLoadingClickReauthoriseButton
		$I->comment("Exiting Action Group [clickReauthoriseButton] AdminAllowResourcesAccessIntegrationActionGroup");
		$grabAfterReauthorizeConsumerKey = $I->grabValueFrom(".admin__field-control.control #integration_token_consumer_key"); // stepKey: grabAfterReauthorizeConsumerKey
		$grabAfterReauthorizeConsumerSecret = $I->grabValueFrom(".admin__field-control.control #integration_token_consumer_secret"); // stepKey: grabAfterReauthorizeConsumerSecret
		$grabReauthorizedAccessToken = $I->grabValueFrom(".admin__field-control.control #integration_token_token"); // stepKey: grabReauthorizedAccessToken
		$grabReauthorizedAccessTokenSecret = $I->grabValueFrom(".admin__field-control.control #integration_token_token_secret"); // stepKey: grabReauthorizedAccessTokenSecret
		$I->comment("Entering Action Group [finishTheProcess] AdminAllowResourcesAccessIntegrationActionGroup");
		$I->click(".page-actions-buttons .action-primary"); // stepKey: clickAllowButtonFinishTheProcess
		$I->waitForPageLoad(30); // stepKey: waitForLoadingFinishTheProcess
		$I->comment("Exiting Action Group [finishTheProcess] AdminAllowResourcesAccessIntegrationActionGroup");
		$I->comment("Entering Action Group [seeSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleSeeSuccessMessage
		$I->see("The integration '" . msq("defaultIntegrationData") . " Integration' has been re-authorized.", "#messages div.message-success"); // stepKey: verifyMessageSeeSuccessMessage
		$I->comment("Exiting Action Group [seeSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [findReAuthorizedIntegration] AdminSearchIntegrationInGridActionGroup");
		$I->comment("Reset Search Filters");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFindReAuthorizedIntegration
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFindReAuthorizedIntegrationWaitForPageLoad
		$I->comment("Fill Integration Name Field");
		$I->fillField(".data-grid-filters #integrationGrid_filter_name", msq("defaultIntegrationData") . " Integration"); // stepKey: filterByNameFindReAuthorizedIntegration
		$I->comment("Click \"Search\" Button");
		$I->click(".admin__filter-actions button[title=Search]"); // stepKey: doFilterFindReAuthorizedIntegration
		$I->waitForPageLoad(30); // stepKey: waitForSitemapPageLoadedAfterFilteringFindReAuthorizedIntegration
		$I->comment("Exiting Action Group [findReAuthorizedIntegration] AdminSearchIntegrationInGridActionGroup");
		$I->comment("Entering Action Group [openIntegrationEntity] AdminIntegrationOpenExistingEntityActionGroup");
		$I->click(".data-grid .edit"); // stepKey: clickEditIconOpenIntegrationEntity
		$I->comment("Exiting Action Group [openIntegrationEntity] AdminIntegrationOpenExistingEntityActionGroup");
		$I->assertEquals(($grabConsumerKey), "$grabAfterReauthorizeConsumerKey"); // stepKey: assertConsumerKey
		$I->assertEquals(($grabConsumerSecret), "$grabAfterReauthorizeConsumerSecret"); // stepKey: assertConsumerSecret
		$I->assertNotEquals(($grabAccessToken), "$grabReauthorizedAccessToken"); // stepKey: assertNotEqualsToken
		$I->assertNotEquals(($grabAccessTokenSecret), "$grabReauthorizedAccessTokenSecret"); // stepKey: assertNotEqualsTokenSecret
	}
}
