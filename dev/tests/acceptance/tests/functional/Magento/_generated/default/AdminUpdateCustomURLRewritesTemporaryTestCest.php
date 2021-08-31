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
 * @Title("MC-5354: Update Custom URL Rewrites, temporary")
 * @Description("Test log in to URL Rewrites and Update Custom URL Rewrites, temporary<h3>Test files</h3>app/code/Magento/UrlRewrite/Test/Mftf/Test/AdminUpdateCustomURLRewritesTemporaryTest.xml<br>")
 * @TestCaseId("MC-5354")
 * @group urlRewrite
 * @group mtf_migrated
 */
class AdminUpdateCustomURLRewritesTemporaryTestCest
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
		$I->createEntity("urlRewrite", "hook", "defaultUrlRewrite", [], []); // stepKey: urlRewrite
		$I->createEntity("createProduct", "hook", "defaultSimpleProduct", [], []); // stepKey: createProduct
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [deleteCustomUrlRewrite] AdminDeleteUrlRewriteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadDeleteCustomUrlRewrite
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteCustomUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadDeleteCustomUrlRewrite
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersDeleteCustomUrlRewriteWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", msq("customTemporaryUrlRewrite") . "wishlist"); // stepKey: fillRedirectPathFilterDeleteCustomUrlRewrite
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
	 * @Stories({"Update Custom URL Rewrites"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"UrlRewrite"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateCustomURLRewritesTemporaryTest(AcceptanceTester $I)
	{
		$I->comment("Filter Product in product page and get the Product ID");
		$I->comment("Entering Action Group [filterProduct] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageFilterProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadFilterProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProduct
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createProduct', 'sku', 'test') . "']]"); // stepKey: openSelectedProductFilterProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadFilterProduct
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleFilterProduct
		$I->comment("Exiting Action Group [filterProduct] FilterAndSelectProductActionGroup");
		$productId = $I->grabFromCurrentUrl("#\/([0-9]*)?\/$#"); // stepKey: productId
		$I->comment("Search default custom url rewrite in grid");
		$I->comment("Entering Action Group [searchUrlRewrite] AdminSearchAndSelectUrlRewriteInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchUrlRewrite
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchUrlRewrite
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchUrlRewrite
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchUrlRewriteWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", $I->retrieveEntityField('urlRewrite', 'request_path', 'test')); // stepKey: fillRequestPathFilterSearchUrlRewrite
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchUrlRewrite
		$I->click("//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Action')]/preceding-sibling::th)+1]//button[contains(@class, 'action-select')]"); // stepKey: clickOnRowSelectButtonSearchUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnRowSelectButtonSearchUrlRewriteWaitForPageLoad
		$I->click("//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Action')]/preceding-sibling::th)+1]//a[contains(., 'Edit')]"); // stepKey: clickOnEditButtonSearchUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnEditButtonSearchUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForEditPageToLoadSearchUrlRewrite
		$I->comment("Exiting Action Group [searchUrlRewrite] AdminSearchAndSelectUrlRewriteInGridActionGroup");
		$I->comment("Update default custom url rewrite as per requirement and verify AssertUrlRewriteSaveMessage");
		$I->comment("Entering Action Group [updateUrlRewrite] AdminUpdateCustomUrlRewriteActionGroup");
		$I->click("//select[@id='store_id']"); // stepKey: clickOnStoreUpdateUrlRewrite
		$I->click("//select[@id='store_id']//option[contains(., 'Default Store View')]"); // stepKey: clickOnStoreValueUpdateUrlRewrite
		$I->fillField("//input[@id='request_path']", msq("customTemporaryUrlRewrite") . "wishlist"); // stepKey: fillRequestPathUpdateUrlRewrite
		$I->fillField("//input[@id='target_path']", "catalog/product/view/id/{$productId}"); // stepKey: fillTargetPathUpdateUrlRewrite
		$I->selectOption("//select[@id='redirect_type']", "Temporary (302)"); // stepKey: selectRedirectTypeValueUpdateUrlRewrite
		$I->fillField("#description", "test_description_relative path"); // stepKey: fillDescriptionUpdateUrlRewrite
		$I->click("#save"); // stepKey: clickOnSaveButtonUpdateUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonUpdateUrlRewriteWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSuccessSaveMessageUpdateUrlRewrite
		$I->comment("Exiting Action Group [updateUrlRewrite] AdminUpdateCustomUrlRewriteActionGroup");
		$I->comment("Search and verify AssertUrlRewriteInGrid");
		$I->comment("Entering Action Group [verifyUpdatedUrlRewriteInGrid] AdminSearchByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageVerifyUpdatedUrlRewriteInGrid
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadVerifyUpdatedUrlRewriteInGrid
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersVerifyUpdatedUrlRewriteInGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersVerifyUpdatedUrlRewriteInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadVerifyUpdatedUrlRewriteInGrid
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersVerifyUpdatedUrlRewriteInGrid
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersVerifyUpdatedUrlRewriteInGridWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", msq("customTemporaryUrlRewrite") . "wishlist"); // stepKey: fillRedirectPathFilterVerifyUpdatedUrlRewriteInGrid
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersVerifyUpdatedUrlRewriteInGrid
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersVerifyUpdatedUrlRewriteInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1VerifyUpdatedUrlRewriteInGrid
		$I->see(msq("customTemporaryUrlRewrite") . "wishlist", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectPathForOldUrlVerifyUpdatedUrlRewriteInGrid
		$I->see("catalog/product/view/id/{$productId}", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheTargetPathVerifyUpdatedUrlRewriteInGrid
		$I->see("Temporary (302)", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Redirect Type')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectTypeForOldUrlVerifyUpdatedUrlRewriteInGrid
		$I->comment("Exiting Action Group [verifyUpdatedUrlRewriteInGrid] AdminSearchByRequestPathActionGroup");
		$I->comment("AssertUrlRewriteCustomSearchRedirect");
		$I->comment("Entering Action Group [verifyProductInStoreFrontPage] AssertStorefrontProductRedirectActionGroup");
		$I->amOnPage($I->retrieveEntityField('createProduct', 'name', 'test') . ".html"); // stepKey: openCategoryInStorefrontVerifyProductInStoreFrontPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadVerifyProductInStoreFrontPage
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), ".base"); // stepKey: seeProductNameInStoreFrontPageVerifyProductInStoreFrontPage
		$I->see($I->retrieveEntityField('createProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: seeProductSkuInStoreFrontPageVerifyProductInStoreFrontPage
		$I->comment("Exiting Action Group [verifyProductInStoreFrontPage] AssertStorefrontProductRedirectActionGroup");
	}
}
