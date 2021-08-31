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
 * @Title("[NO TESTCASEID]: Update CMS Page URL Redirect With No Redirect")
 * @Description("Login as Admin and tried to update the created URL Rewrite for CMS page<h3>Test files</h3>app/code/Magento/UrlRewrite/Test/Mftf/Test/AdminUpdateCmsPageRewriteEntityWithNoRedirectTest.xml<br>")
 * @group cMSContent
 * @group mtf_migrated
 */
class AdminUpdateCmsPageRewriteEntityWithNoRedirectTestCest
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
		$I->createEntity("createCMSPage", "hook", "simpleCmsPage", [], []); // stepKey: createCMSPage
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
		$I->deleteEntity("createCMSPage", "hook"); // stepKey: deleteCMSPage
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
	 * @Stories({"Update CMS Page URL Redirect With No Redirect"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Features({"UrlRewrite"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateCmsPageRewriteEntityWithNoRedirectTest(AcceptanceTester $I)
	{
		$I->comment("Create Custom Store View");
		$I->comment("Entering Action Group [createCustomStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateCustomStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateCustomStoreView
		$I->fillField("#store_name", "store" . msq("customStore")); // stepKey: enterStoreViewNameCreateCustomStoreView
		$I->fillField("#store_code", "store" . msq("customStore")); // stepKey: enterStoreViewCodeCreateCustomStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateCustomStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateCustomStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateCustomStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateCustomStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateCustomStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateCustomStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateCustomStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateCustomStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateCustomStoreView
		$I->comment("Exiting Action Group [createCustomStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Open CMS Edit Page, Get the CMS ID and Modify Store View Option to All Store Views");
		$I->comment("Entering Action Group [navigateToCreatedCMSPage] NavigateToCreatedCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridNavigateToCreatedCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedCMSPage
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterNavigateToCreatedCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedCMSPage
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingNavigateToCreatedCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishNavigateToCreatedCMSPage
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingNavigateToCreatedCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishNavigateToCreatedCMSPage
		$I->click("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectCreatedCMSPageNavigateToCreatedCMSPage
		$I->click("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Edit']"); // stepKey: navigateToCreatedCMSPageNavigateToCreatedCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCreatedCMSPage
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageNavigateToCreatedCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOfStagingSectionNavigateToCreatedCMSPage
		$I->comment("Exiting Action Group [navigateToCreatedCMSPage] NavigateToCreatedCMSPageActionGroup");
		$cmsId = $I->grabFromCurrentUrl("#\/([0-9]*)?\/$#"); // stepKey: cmsId
		$I->comment("Entering Action Group [updateStoreViewForCmsPage] AddStoreViewToCmsPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridUpdateStoreViewForCmsPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1UpdateStoreViewForCmsPage
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterUpdateStoreViewForCmsPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2UpdateStoreViewForCmsPage
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingUpdateStoreViewForCmsPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishUpdateStoreViewForCmsPage
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingUpdateStoreViewForCmsPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishUpdateStoreViewForCmsPage
		$I->click("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectCreatedCMSPageUpdateStoreViewForCmsPage
		$I->click("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Edit']"); // stepKey: navigateToCreatedCMSPageUpdateStoreViewForCmsPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3UpdateStoreViewForCmsPage
		$I->click("div[data-index=websites]"); // stepKey: clickPageInWebsitesUpdateStoreViewForCmsPage
		$I->waitForPageLoad(30); // stepKey: clickPageInWebsitesUpdateStoreViewForCmsPageWaitForPageLoad
		$I->waitForElementVisible("//option[contains(text(),'All Store Views')]", 30); // stepKey: waitForStoreGridReloadUpdateStoreViewForCmsPage
		$I->clickWithLeftButton("//option[contains(text(),'All Store Views')]"); // stepKey: clickStoreViewUpdateStoreViewForCmsPage
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandButtonMenuUpdateStoreViewForCmsPage
		$I->waitForPageLoad(10); // stepKey: expandButtonMenuUpdateStoreViewForCmsPageWaitForPageLoad
		$I->waitForElementVisible("//ul[@data-ui-id='save-button-dropdown-menu']", 30); // stepKey: waitForSplitButtonMenuVisibleUpdateStoreViewForCmsPage
		$I->waitForPageLoad(10); // stepKey: waitForSplitButtonMenuVisibleUpdateStoreViewForCmsPageWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSavePageUpdateStoreViewForCmsPage
		$I->waitForPageLoad(10); // stepKey: clickSavePageUpdateStoreViewForCmsPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadUpdateStoreViewForCmsPage
		$I->see("You saved the page."); // stepKey: seeMessageUpdateStoreViewForCmsPage
		$I->comment("Exiting Action Group [updateStoreViewForCmsPage] AddStoreViewToCmsPageActionGroup");
		$I->comment("Create CMS Page URL Redirect");
		$I->comment("Entering Action Group [addCustomUrlRewrite] AdminAddCustomUrlRewriteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/edit/id/"); // stepKey: openUrlRewriteEditPageAddCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadAddCustomUrlRewrite
		$I->click("//select[@id='entity-type-selector']"); // stepKey: clickOnCustonUrlRewriteAddCustomUrlRewrite
		$I->click("//select[@id='entity-type-selector']/option[contains(.,'Custom')]"); // stepKey: selectCustomAddCustomUrlRewrite
		$I->click("//select[@id='store_id']"); // stepKey: clickOnStoreAddCustomUrlRewrite
		$I->click("//select[@id='store_id']//option[contains(., 'Default Store View')]"); // stepKey: clickOnStoreValueAddCustomUrlRewrite
		$I->fillField("//input[@id='request_path']", "created-new-cms-page"); // stepKey: fillRequestPathAddCustomUrlRewrite
		$I->fillField("//input[@id='target_path']", "cms/page/view/page_id/{$cmsId}"); // stepKey: fillTargetPathAddCustomUrlRewrite
		$I->click("//select[@id='redirect_type']"); // stepKey: selectRedirectTypeAddCustomUrlRewrite
		$I->click("//select[@id='redirect_type']//option[contains(., 'Permanent (301)')]"); // stepKey: selectRedirectTypeValueAddCustomUrlRewrite
		$I->fillField("#description", "Created New CMS Page"); // stepKey: fillDescriptionAddCustomUrlRewrite
		$I->click("#save"); // stepKey: clickOnSaveButtonAddCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonAddCustomUrlRewriteWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSuccessSaveMessageAddCustomUrlRewrite
		$I->comment("Exiting Action Group [addCustomUrlRewrite] AdminAddCustomUrlRewriteActionGroup");
		$I->comment("Search created CMS page url rewrite in grid");
		$I->comment("Entering Action Group [searchUrlRewrite] AdminSearchAndSelectUrlRewriteInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchUrlRewrite
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchUrlRewrite
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchUrlRewrite
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchUrlRewriteWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "created-new-cms-page"); // stepKey: fillRequestPathFilterSearchUrlRewrite
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchUrlRewrite
		$I->click("//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Action')]/preceding-sibling::th)+1]//button[contains(@class, 'action-select')]"); // stepKey: clickOnRowSelectButtonSearchUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnRowSelectButtonSearchUrlRewriteWaitForPageLoad
		$I->click("//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Action')]/preceding-sibling::th)+1]//a[contains(., 'Edit')]"); // stepKey: clickOnEditButtonSearchUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnEditButtonSearchUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForEditPageToLoadSearchUrlRewrite
		$I->comment("Exiting Action Group [searchUrlRewrite] AdminSearchAndSelectUrlRewriteInGridActionGroup");
		$I->comment("Update URL Rewrite for CMS Page");
		$I->comment("Entering Action Group [updateUrlRewriteFirstAttempt] AdminUpdateUrlRewriteActionGroup");
		$I->click("//select[@id='store_id']"); // stepKey: clickOnStoreUpdateUrlRewriteFirstAttempt
		$I->click("//select[@id='store_id']//option[contains(., 'store" . msq("customStore") . "')]"); // stepKey: clickOnStoreValueUpdateUrlRewriteFirstAttempt
		$I->fillField("//input[@id='request_path']", "newrequestpath"); // stepKey: fillRequestPathUpdateUrlRewriteFirstAttempt
		$I->click("//select[@id='redirect_type']"); // stepKey: selectRedirectTypeUpdateUrlRewriteFirstAttempt
		$I->click("//select[@id='redirect_type']//option[contains(., 'No')]"); // stepKey: selectRedirectTypeValueUpdateUrlRewriteFirstAttempt
		$I->fillField("#description", "test_description_custom_store"); // stepKey: fillDescriptionUpdateUrlRewriteFirstAttempt
		$I->click("#save"); // stepKey: clickOnSaveButtonUpdateUrlRewriteFirstAttempt
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonUpdateUrlRewriteFirstAttemptWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSuccessSaveMessageUpdateUrlRewriteFirstAttempt
		$I->comment("Exiting Action Group [updateUrlRewriteFirstAttempt] AdminUpdateUrlRewriteActionGroup");
		$I->comment("Assert Url Rewrite Save Message");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleAssertSuccessMessage
		$I->see("The URL Rewrite has been saved.", "#messages div.message-success"); // stepKey: verifyMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Assert Url Rewrite Cms Page Redirect");
		$I->comment("Entering Action Group [goToHomepage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomepage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomepage
		$I->comment("Exiting Action Group [goToHomepage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [storefrontSwitchToCustomStoreView] StorefrontSwitchStoreViewActionGroup");
		$I->click("#switcher-language-trigger"); // stepKey: clickStoreViewSwitcherStorefrontSwitchToCustomStoreView
		$I->waitForElementVisible(".active ul.switcher-dropdown", 30); // stepKey: waitForStoreViewDropdownStorefrontSwitchToCustomStoreView
		$I->click("li.view-store" . msq("customStore") . ">a"); // stepKey: clickSelectStoreViewStorefrontSwitchToCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadStorefrontSwitchToCustomStoreView
		$I->comment("Exiting Action Group [storefrontSwitchToCustomStoreView] StorefrontSwitchStoreViewActionGroup");
		$I->comment("Entering Action Group [navigateToTheStoreFront] NavigateToStorefrontForCreatedPageActionGroup");
		$I->amOnPage("newrequestpath"); // stepKey: goToStorefrontNavigateToTheStoreFront
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToTheStoreFront
		$I->comment("Exiting Action Group [navigateToTheStoreFront] NavigateToStorefrontForCreatedPageActionGroup");
		$I->comment("Entering Action Group [assertCMSPage] AssertStoreFrontCMSPageActionGroup");
		$I->see($I->retrieveEntityField('createCMSPage', 'title', 'test'), "//div[@class='breadcrumbs']//ul/li[@class='item cms_page']"); // stepKey: seeTitleAssertCMSPage
		$I->see($I->retrieveEntityField('createCMSPage', 'content_heading', 'test'), "#maincontent .page-title"); // stepKey: seeContentHeadingAssertCMSPage
		$I->see($I->retrieveEntityField('createCMSPage', 'content', 'test'), "#maincontent"); // stepKey: seeContentAssertCMSPage
		$I->comment("Exiting Action Group [assertCMSPage] AssertStoreFrontCMSPageActionGroup");
		$I->comment("Entering Action Group [deleteCustomUrlRewrite] AdminDeleteUrlRewriteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadDeleteCustomUrlRewrite
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteCustomUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadDeleteCustomUrlRewrite
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersDeleteCustomUrlRewriteWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "newrequestpath"); // stepKey: fillRedirectPathFilterDeleteCustomUrlRewrite
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersDeleteCustomUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1DeleteCustomUrlRewrite
		$I->click("//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Action')]/preceding-sibling::th)+1]//button[contains(@class, 'action-select')]"); // stepKey: clickOnRowSelectButtonDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnRowSelectButtonDeleteCustomUrlRewriteWaitForPageLoad
		$I->click("//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Action')]/preceding-sibling::th)+1]//a[contains(., 'Edit')]"); // stepKey: clickOnEditButtonDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnEditButtonDeleteCustomUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForEditPageToLoadDeleteCustomUrlRewrite
		$I->click("#delete"); // stepKey: clickOnDeleteButtonDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteButtonDeleteCustomUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad2DeleteCustomUrlRewrite
		$I->waitForElementVisible("//button[@class='action-primary action-accept']", 30); // stepKey: waitForOkButtonToVisibleDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForOkButtonToVisibleDeleteCustomUrlRewriteWaitForPageLoad
		$I->click("//button[@class='action-primary action-accept']"); // stepKey: clickOnOkButtonDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnOkButtonDeleteCustomUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad3DeleteCustomUrlRewrite
		$I->see("You deleted the URL rewrite.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCustomUrlRewrite
		$I->comment("Exiting Action Group [deleteCustomUrlRewrite] AdminDeleteUrlRewriteActionGroup");
		$I->comment("Entering Action Group [deleteCustomStoreView] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteCustomStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteCustomStoreViewWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "store" . msq("customStore")); // stepKey: fillStoreViewFilterFieldDeleteCustomStoreView
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteCustomStoreViewWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteCustomStoreViewWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteCustomStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteCustomStoreViewWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteCustomStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteCustomStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteCustomStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteCustomStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteCustomStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteCustomStoreView
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteCustomStoreView
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteCustomStoreView
		$I->comment("Exiting Action Group [deleteCustomStoreView] AdminDeleteStoreViewActionGroup");
	}
}
