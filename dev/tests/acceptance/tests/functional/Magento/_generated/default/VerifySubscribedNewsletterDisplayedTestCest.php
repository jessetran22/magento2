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
 * @group Newsletter
 * @Title("MC-25840: Newsletter subscription when user is registered on 2 stores")
 * @Description("Newsletter subscription when user is registered on 2 stores<h3>Test files</h3>app/code/Magento/Newsletter/Test/Mftf/Test/VerifySubscribedNewsletterDisplayedTest.xml<br>")
 * @TestCaseId("MC-25840")
 */
class VerifySubscribedNewsletterDisplayedTestCest
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
		$I->comment("Log in to Magento as admin.");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [createWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageCreateWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadCreateWebsite
		$I->comment("Create Website");
		$I->fillField("#website_name", "Second Website" . msq("customWebsite")); // stepKey: enterWebsiteNameCreateWebsite
		$I->fillField("#website_code", "second_website" . msq("customWebsite")); // stepKey: enterWebsiteCodeCreateWebsite
		$I->click("#save"); // stepKey: clickSaveWebsiteCreateWebsite
		$I->waitForPageLoad(60); // stepKey: clickSaveWebsiteCreateWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadCreateWebsite
		$I->see("You saved the website."); // stepKey: seeSavedMessageCreateWebsite
		$I->comment("Exiting Action Group [createWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Entering Action Group [createNewStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateNewStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateNewStore
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Second Website" . msq("customWebsite")); // stepKey: selectWebsiteCreateNewStore
		$I->fillField("#group_name", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupNameCreateNewStore
		$I->fillField("#group_code", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupCodeCreateNewStore
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateNewStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateNewStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateNewStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateNewStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateNewStore
		$I->comment("Exiting Action Group [createNewStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Entering Action Group [createCustomStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateCustomStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStoreGroup")); // stepKey: selectStoreCreateCustomStoreView
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
		$I->comment("Entering Action Group [addStoreCodeToUrls] EnableWebUrlOptionsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/web/"); // stepKey: navigateToWebConfigurationPageAddStoreCodeToUrls
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddStoreCodeToUrls
		$I->conditionalClick("#web_url-head", "#web_url-head:not(.open)", true); // stepKey: expandUrlSectionTabAddStoreCodeToUrls
		$I->waitForElementVisible("#web_url_use_store", 30); // stepKey: seeAddStoreCodeToUrlAddStoreCodeToUrls
		$I->uncheckOption("#web_url_use_store_inherit"); // stepKey: uncheckUseSystemValueAddStoreCodeToUrls
		$I->selectOption("#web_url_use_store", "Yes"); // stepKey: enableStoreCodeAddStoreCodeToUrls
		$I->click("#web_url-head"); // stepKey: collapseUrlOptionsAddStoreCodeToUrls
		$I->click("#save"); // stepKey: saveConfigAddStoreCodeToUrls
		$I->waitForPageLoad(30); // stepKey: saveConfigAddStoreCodeToUrlsWaitForPageLoad
		$I->comment("Exiting Action Group [addStoreCodeToUrls] EnableWebUrlOptionsActionGroup");
		$I->comment("Entering Action Group [flushCache] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushCache = $I->magentoCLI("cache:flush", 60, ""); // stepKey: flushSpecifiedCacheFlushCache
		$I->comment($flushSpecifiedCacheFlushCache);
		$I->comment("Exiting Action Group [flushCache] CliCacheFlushActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created data and set Default Configuration");
		$I->comment("Entering Action Group [resetUrlOption] ResetWebUrlOptionsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/web/"); // stepKey: navigateToWebConfigurationPagetoResetResetUrlOption
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2ResetUrlOption
		$I->conditionalClick("#web_url-head", "#web_url-head:not(.open)", true); // stepKey: closeUrlSectionTabResetUrlOption
		$I->waitForElementVisible("#web_url_use_store", 30); // stepKey: seeAddStoreCodeToUrl2ResetUrlOption
		$I->comment("<uncheckOption selector=\"\{\{UrlOptionsSection.systemValueForStoreCode\}\}\" stepKey=\"uncheckUseSystemValue\"/>");
		$I->selectOption("#web_url_use_store", "No"); // stepKey: enableStoreCodeResetUrlOption
		$I->checkOption("#web_url_use_store_inherit"); // stepKey: checkUseSystemValueResetUrlOption
		$I->click("#web_url-head"); // stepKey: collapseUrlOptionsResetUrlOption
		$I->click("#save"); // stepKey: saveConfigResetUrlOption
		$I->waitForPageLoad(30); // stepKey: saveConfigResetUrlOptionWaitForPageLoad
		$I->comment("Exiting Action Group [resetUrlOption] ResetWebUrlOptionsActionGroup");
		$I->comment("Entering Action Group [deleteWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "Second Website" . msq("customWebsite")); // stepKey: fillSearchWebsiteFieldDeleteWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteWebsiteWaitForPageLoad
		$I->see("Second Website" . msq("customWebsite"), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteWebsite
		$I->click("tr:nth-of-type(1) > .col-website_title > a"); // stepKey: clickEditExistingStoreRowDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteStoreGroupSectionLoadDeleteWebsite
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonDeleteWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadDeleteWebsite
		$I->see("You deleted the website."); // stepKey: seeSavedMessageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilter2DeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilter2DeleteWebsiteWaitForPageLoad
		$I->comment("Exiting Action Group [deleteWebsite] AdminDeleteWebsiteActionGroup");
		$I->comment("Entering Action Group [clearFilters] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearFilters
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearFilters
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFilters
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilters] AdminClearFiltersActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [flushCache] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushCache = $I->magentoCLI("cache:flush", 60, ""); // stepKey: flushSpecifiedCacheFlushCache
		$I->comment($flushSpecifiedCacheFlushCache);
		$I->comment("Exiting Action Group [flushCache] CliCacheFlushActionGroup");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Features({"Newsletter"})
	 * @Stories({"MAGETWO-91701: Newsletter subscription is not correctly updated when user is registered on 2 stores"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function VerifySubscribedNewsletterDisplayedTest(AcceptanceTester $I)
	{
		$I->comment("Go to store front (default) and click Create an Account.");
		$I->comment("Entering Action Group [SignUpNewUser] StorefrontCreateNewAccountNewsletterCheckedActionGroup");
		$I->amOnPage("/"); // stepKey: amOnStorefrontPageSignUpNewUser
		$I->waitForElementVisible("//div[@class='panel wrapper']//li/a[contains(.,'Create an Account')]", 30); // stepKey: waitForCreateAccountLinkSignUpNewUser
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountLinkSignUpNewUserWaitForPageLoad
		$I->click("//div[@class='panel wrapper']//li/a[contains(.,'Create an Account')]"); // stepKey: clickOnCreateAccountLinkSignUpNewUser
		$I->waitForPageLoad(30); // stepKey: clickOnCreateAccountLinkSignUpNewUserWaitForPageLoad
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameSignUpNewUser
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameSignUpNewUser
		$I->click("//span[contains(text(), 'Sign Up for Newsletter')]"); // stepKey: selectSignUpForNewsletterCheckboxSignUpNewUser
		$I->fillField("#email_address", msq("CustomerEntityOne") . "test@email.com"); // stepKey: fillEmailSignUpNewUser
		$I->fillField("#password", "pwdTest123!"); // stepKey: fillPasswordSignUpNewUser
		$I->fillField("#password-confirmation", "pwdTest123!"); // stepKey: fillConfirmPasswordSignUpNewUser
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountButtonIsActiveSignUpNewUser
		$I->click("button.action.submit.primary"); // stepKey: clickCreateAccountButtonSignUpNewUser
		$I->waitForPageLoad(30); // stepKey: clickCreateAccountButtonSignUpNewUserWaitForPageLoad
		$I->see("Thank you for registering with Main Website Store."); // stepKey: seeThankYouMessageSignUpNewUser
		$I->see("John", ".box.box-information .box-content"); // stepKey: seeFirstNameSignUpNewUser
		$I->see("Doe", ".box.box-information .box-content"); // stepKey: seeLastNameSignUpNewUser
		$I->see(msq("CustomerEntityOne") . "test@email.com", ".box.box-information .box-content"); // stepKey: seeEmailSignUpNewUser
		$I->see("You are subscribed to \"General Subscription\".", ".box-newsletter p"); // stepKey: seeDescriptionNewsletterSignUpNewUser
		$I->comment("Exiting Action Group [SignUpNewUser] StorefrontCreateNewAccountNewsletterCheckedActionGroup");
		$I->comment("Sign Out");
		$I->amOnPage("customer/account/logout/"); // stepKey: customerOnLogoutPage
		$I->waitForPageLoad(30); // stepKey: waitLogoutCustomer
		$I->comment("Create new Account with the same email address. (unchecked Sign Up for Newsletter checkbox)");
		$I->comment("Entering Action Group [createNewAccountNewsletterUnchecked] StorefrontCreateNewAccountNewsletterUncheckedActionGroup");
		$I->amOnPage("store" . msq("customStore")); // stepKey: amOnStorefrontPageCreateNewAccountNewsletterUnchecked
		$I->waitForElementVisible("//div[@class='panel wrapper']//li/a[contains(.,'Create an Account')]", 30); // stepKey: waitForCreateAccountLinkCreateNewAccountNewsletterUnchecked
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountLinkCreateNewAccountNewsletterUncheckedWaitForPageLoad
		$I->click("//div[@class='panel wrapper']//li/a[contains(.,'Create an Account')]"); // stepKey: clickOnCreateAccountLinkCreateNewAccountNewsletterUnchecked
		$I->waitForPageLoad(30); // stepKey: clickOnCreateAccountLinkCreateNewAccountNewsletterUncheckedWaitForPageLoad
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameCreateNewAccountNewsletterUnchecked
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameCreateNewAccountNewsletterUnchecked
		$I->fillField("#email_address", msq("CustomerEntityOne") . "test@email.com"); // stepKey: fillEmailCreateNewAccountNewsletterUnchecked
		$I->fillField("#password", "pwdTest123!"); // stepKey: fillPasswordCreateNewAccountNewsletterUnchecked
		$I->fillField("#password-confirmation", "pwdTest123!"); // stepKey: fillConfirmPasswordCreateNewAccountNewsletterUnchecked
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountButtonIsActiveCreateNewAccountNewsletterUnchecked
		$I->click("button.action.submit.primary"); // stepKey: clickCreateAccountButtonCreateNewAccountNewsletterUnchecked
		$I->waitForPageLoad(30); // stepKey: clickCreateAccountButtonCreateNewAccountNewsletterUncheckedWaitForPageLoad
		$I->see("Thank you for registering with store" . msq("customStoreGroup") . "."); // stepKey: seeThankYouMessageCreateNewAccountNewsletterUnchecked
		$I->see("John", ".box.box-information .box-content"); // stepKey: seeFirstNameCreateNewAccountNewsletterUnchecked
		$I->see("Doe", ".box.box-information .box-content"); // stepKey: seeLastNameCreateNewAccountNewsletterUnchecked
		$I->see(msq("CustomerEntityOne") . "test@email.com", ".box.box-information .box-content"); // stepKey: seeEmailCreateNewAccountNewsletterUnchecked
		$I->see("You aren't subscribed to our newsletter.", ".box-newsletter p"); // stepKey: seeDescriptionNewsletterCreateNewAccountNewsletterUnchecked
		$I->comment("Exiting Action Group [createNewAccountNewsletterUnchecked] StorefrontCreateNewAccountNewsletterUncheckedActionGroup");
	}
}
