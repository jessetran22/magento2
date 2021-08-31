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
 * @Title("MC-5344: Create custom URL rewrite, temporary")
 * @Description("Login as Admin and create custom product UrlRewrite and add Temporary redirect type<h3>Test files</h3>app/code/Magento/UrlRewrite/Test/Mftf/Test/AdminCreateCustomProductUrlRewriteAndAddTemporaryRedirectTest.xml<br>")
 * @TestCaseId("MC-5344")
 * @group mtf_migrated
 */
class AdminCreateCustomProductUrlRewriteAndAddTemporaryRedirectTestCest
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
		$I->createEntity("createProduct", "hook", "defaultSimpleProduct", [], []); // stepKey: createProduct
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
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [deleteCustomUrlRewrite] AdminDeleteUrlRewriteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadDeleteCustomUrlRewrite
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteCustomUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadDeleteCustomUrlRewrite
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersDeleteCustomUrlRewriteWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "testProductName" . msq("_defaultProduct") . ".html"); // stepKey: fillRedirectPathFilterDeleteCustomUrlRewrite
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
	 * @Stories({"Create custom URL rewrite"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"UrlRewrite"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCustomProductUrlRewriteAndAddTemporaryRedirectTest(AcceptanceTester $I)
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
		$I->comment("Open UrlRewrite Edit page and update the fields and fill the created product Target Path");
		$I->comment("Entering Action Group [addCustomUrlRewrite] AdminAddCustomUrlRewriteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/edit/id/"); // stepKey: openUrlRewriteEditPageAddCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadAddCustomUrlRewrite
		$I->click("//select[@id='entity-type-selector']"); // stepKey: clickOnCustonUrlRewriteAddCustomUrlRewrite
		$I->click("//select[@id='entity-type-selector']/option[contains(.,'Custom')]"); // stepKey: selectCustomAddCustomUrlRewrite
		$I->click("//select[@id='store_id']"); // stepKey: clickOnStoreAddCustomUrlRewrite
		$I->click("//select[@id='store_id']//option[contains(., 'Default Store View')]"); // stepKey: clickOnStoreValueAddCustomUrlRewrite
		$I->fillField("//input[@id='request_path']", "testProductName" . msq("_defaultProduct") . ".html"); // stepKey: fillRequestPathAddCustomUrlRewrite
		$I->fillField("//input[@id='target_path']", "catalog/product/view/id/{$productId}"); // stepKey: fillTargetPathAddCustomUrlRewrite
		$I->click("//select[@id='redirect_type']"); // stepKey: selectRedirectTypeAddCustomUrlRewrite
		$I->click("//select[@id='redirect_type']//option[contains(., 'Temporary (302)')]"); // stepKey: selectRedirectTypeValueAddCustomUrlRewrite
		$I->fillField("#description", "End To End Test"); // stepKey: fillDescriptionAddCustomUrlRewrite
		$I->click("#save"); // stepKey: clickOnSaveButtonAddCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonAddCustomUrlRewriteWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSuccessSaveMessageAddCustomUrlRewrite
		$I->comment("Exiting Action Group [addCustomUrlRewrite] AdminAddCustomUrlRewriteActionGroup");
		$I->comment("Assert updated product Url Rewrite in Grid");
		$I->comment("Entering Action Group [searchByRequestPath] AdminSearchByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchByRequestPath
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchByRequestPath
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchByRequestPath
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchByRequestPathWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchByRequestPath
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchByRequestPath
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchByRequestPathWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "testProductName" . msq("_defaultProduct") . ".html"); // stepKey: fillRedirectPathFilterSearchByRequestPath
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchByRequestPath
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchByRequestPathWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchByRequestPath
		$I->see("testProductName" . msq("_defaultProduct") . ".html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectPathForOldUrlSearchByRequestPath
		$I->see("catalog/product/view/id/{$productId}", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheTargetPathSearchByRequestPath
		$I->see("Temporary (302)", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Redirect Type')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectTypeForOldUrlSearchByRequestPath
		$I->comment("Exiting Action Group [searchByRequestPath] AdminSearchByRequestPathActionGroup");
		$I->comment("Assert initial product Url rewrite in grid");
		$I->comment("Entering Action Group [searchByRequestPath1] AdminSearchByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchByRequestPath1
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchByRequestPath1
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchByRequestPath1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchByRequestPath1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchByRequestPath1
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchByRequestPath1
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchByRequestPath1WaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", $I->retrieveEntityField('createProduct', 'name', 'test') . ".html"); // stepKey: fillRedirectPathFilterSearchByRequestPath1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchByRequestPath1
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchByRequestPath1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchByRequestPath1
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test') . ".html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectPathForOldUrlSearchByRequestPath1
		$I->see("catalog/product/view/id/{$productId}", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheTargetPathSearchByRequestPath1
		$I->see("No", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Redirect Type')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectTypeForOldUrlSearchByRequestPath1
		$I->comment("Exiting Action Group [searchByRequestPath1] AdminSearchByRequestPathActionGroup");
		$I->comment("Assert updated product redirect in Store Front");
		$I->comment("Entering Action Group [verifyProductInStoreFront] AssertStorefrontProductRedirectActionGroup");
		$I->amOnPage("testProductName" . msq("_defaultProduct") . ".html"); // stepKey: openCategoryInStorefrontVerifyProductInStoreFront
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadVerifyProductInStoreFront
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), ".base"); // stepKey: seeProductNameInStoreFrontPageVerifyProductInStoreFront
		$I->see($I->retrieveEntityField('createProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: seeProductSkuInStoreFrontPageVerifyProductInStoreFront
		$I->comment("Exiting Action Group [verifyProductInStoreFront] AssertStorefrontProductRedirectActionGroup");
		$I->comment("Assert initial product redirect in Store Front");
		$I->comment("Entering Action Group [verifyProductInStoreFront1] AssertStorefrontProductRedirectActionGroup");
		$I->amOnPage($I->retrieveEntityField('createProduct', 'name', 'test') . ".html"); // stepKey: openCategoryInStorefrontVerifyProductInStoreFront1
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadVerifyProductInStoreFront1
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), ".base"); // stepKey: seeProductNameInStoreFrontPageVerifyProductInStoreFront1
		$I->see($I->retrieveEntityField('createProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: seeProductSkuInStoreFrontPageVerifyProductInStoreFront1
		$I->comment("Exiting Action Group [verifyProductInStoreFront1] AssertStorefrontProductRedirectActionGroup");
	}
}
