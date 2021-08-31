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
 * @Title("MC-5338: Create product URL rewrite, add temporary redirect for product")
 * @Description("Login as admin, create product with category and UrlRewrite and add temporary redirect<h3>Test files</h3>app/code/Magento/UrlRewrite/Test/Mftf/Test/AdminCreateProductURLRewriteWithCategoryAndAddTemporaryRedirectTest.xml<br>")
 * @TestCaseId("MC-5338")
 * @group mtf_migrated
 */
class AdminCreateProductURLRewriteWithCategoryAndAddTemporaryRedirectTestCest
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
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteProduct
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
	 * @Stories({"Create Product UrlRewrite"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"UrlRewrite"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateProductURLRewriteWithCategoryAndAddTemporaryRedirectTest(AcceptanceTester $I)
	{
		$I->comment("Filter and Select the created Product");
		$I->comment("Entering Action Group [searchProduct] AdminSearchUrlRewriteProductBySkuActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/edit/product"); // stepKey: openUrlRewriteProductPageSearchProduct
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteProductPageToLoadSearchProduct
		$I->click("//button[@data-action='grid-filter-reset']"); // stepKey: clickOnResetFilterSearchProduct
		$I->waitForPageLoad(30); // stepKey: clickOnResetFilterSearchProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchProduct
		$I->fillField("//input[@name='sku']", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterSearchProduct
		$I->click("//button[@data-action='grid-filter-apply']"); // stepKey: clickOnSearchFilterSearchProduct
		$I->waitForPageLoad(30); // stepKey: clickOnSearchFilterSearchProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadSearchProduct
		$I->click("//tbody/tr/td[contains(@class,'col-sku')]"); // stepKey: clickOnFirstRowSearchProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductCategoryPageToLoadSearchProduct
		$I->comment("Exiting Action Group [searchProduct] AdminSearchUrlRewriteProductBySkuActionGroup");
		$I->comment("Update the Store, RequestPath, RedirectType and Description");
		$I->comment("Entering Action Group [addUrlRewrite] AdminAddUrlRewriteForProductActionGroup");
		$I->waitForElementVisible("//button[@class='action-default scalable save']", 30); // stepKey: waitForSkipCategoryButtonAddUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForSkipCategoryButtonAddUrlRewriteWaitForPageLoad
		$I->click("//button[@class='action-default scalable save']"); // stepKey: clickOnSkipCategoryButtonAddUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnSkipCategoryButtonAddUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductPageToLoadAddUrlRewrite
		$I->click("//select[@id='store_id']"); // stepKey: clickOnStoreAddUrlRewrite
		$I->click("//select[@id='store_id']//option[contains(., 'Default Store View')]"); // stepKey: clickOnStoreValueAddUrlRewrite
		$I->fillField("//input[@id='request_path']", "firstlevelsubcategory" . msq("FirstLevelSubCat") . "/testproductname" . msq("_defaultProduct") . ".html"); // stepKey: fillRequestPathAddUrlRewrite
		$I->click("//select[@id='redirect_type']"); // stepKey: selectRedirectTypeAddUrlRewrite
		$I->click("//select[@id='redirect_type']//option[contains(., 'Temporary (302)')]"); // stepKey: clickOnRedirectTypeValueAddUrlRewrite
		$I->fillField("#description", "End To End Test"); // stepKey: fillDescriptionAddUrlRewrite
		$I->click("#save"); // stepKey: clickOnSaveButtonAddUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonAddUrlRewriteWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSuccessSaveMessageAddUrlRewrite
		$I->comment("Exiting Action Group [addUrlRewrite] AdminAddUrlRewriteForProductActionGroup");
		$I->comment("Assert Product Redirect");
		$I->comment("Entering Action Group [searchByRequestPath] AdminSearchByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchByRequestPath
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchByRequestPath
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchByRequestPath
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchByRequestPathWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchByRequestPath
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchByRequestPath
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchByRequestPathWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "firstlevelsubcategory" . msq("FirstLevelSubCat") . "/testproductname" . msq("_defaultProduct") . ".html"); // stepKey: fillRedirectPathFilterSearchByRequestPath
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchByRequestPath
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchByRequestPathWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchByRequestPath
		$I->see("firstlevelsubcategory" . msq("FirstLevelSubCat") . "/testproductname" . msq("_defaultProduct") . ".html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectPathForOldUrlSearchByRequestPath
		$I->see($I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheTargetPathSearchByRequestPath
		$I->see("Temporary (302)", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Redirect Type')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectTypeForOldUrlSearchByRequestPath
		$I->comment("Exiting Action Group [searchByRequestPath] AdminSearchByRequestPathActionGroup");
		$I->comment("Filter Product in product page and get the Product ID");
		$I->comment("Entering Action Group [filterProduct] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageFilterProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadFilterProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProduct
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "']]"); // stepKey: openSelectedProductFilterProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadFilterProduct
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleFilterProduct
		$I->comment("Exiting Action Group [filterProduct] FilterAndSelectProductActionGroup");
		$productId = $I->grabFromCurrentUrl("#\/([0-9]*)?\/$#"); // stepKey: productId
		$I->comment("Assert Redirect path, Target Path and Redirect type in grid");
		$I->comment("Entering Action Group [searchByRequestPath1] AdminSearchByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchByRequestPath1
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchByRequestPath1
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchByRequestPath1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchByRequestPath1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchByRequestPath1
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchByRequestPath1
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchByRequestPath1WaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: fillRedirectPathFilterSearchByRequestPath1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchByRequestPath1
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchByRequestPath1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchByRequestPath1
		$I->see($I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectPathForOldUrlSearchByRequestPath1
		$I->see("catalog/product/view/id/{$productId}", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheTargetPathSearchByRequestPath1
		$I->see("No", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Redirect Type')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectTypeForOldUrlSearchByRequestPath1
		$I->comment("Exiting Action Group [searchByRequestPath1] AdminSearchByRequestPathActionGroup");
		$I->comment("Open Category Page and Get Category ID");
		$I->comment("Entering Action Group [getCategoryId] OpenCategoryFromCategoryTreeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageGetCategoryId
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadGetCategoryId
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeGetCategoryId
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadGetCategoryId
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]"); // stepKey: selectCategoryGetCategoryId
		$I->waitForPageLoad(30); // stepKey: selectCategoryGetCategoryIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGetCategoryId
		$I->waitForElementVisible("h1.page-title", 30); // stepKey: waitForCategoryTitleGetCategoryId
		$I->comment("Exiting Action Group [getCategoryId] OpenCategoryFromCategoryTreeActionGroup");
		$categoryId = $I->grabFromCurrentUrl("#\/([0-9]*)?\/$#"); // stepKey: categoryId
		$I->comment("Assert Redirect path, Target Path and Redirect type in grid");
		$I->comment("Entering Action Group [searchByRequestPath2] AdminSearchByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchByRequestPath2
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchByRequestPath2
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchByRequestPath2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchByRequestPath2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchByRequestPath2
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchByRequestPath2
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchByRequestPath2WaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", $I->retrieveEntityField('createCategory', 'name', 'test') . ".html"); // stepKey: fillRedirectPathFilterSearchByRequestPath2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchByRequestPath2
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchByRequestPath2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchByRequestPath2
		$I->see($I->retrieveEntityField('createCategory', 'name', 'test') . ".html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectPathForOldUrlSearchByRequestPath2
		$I->see("catalog/category/view/id/{$categoryId}", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheTargetPathSearchByRequestPath2
		$I->see("No", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Redirect Type')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectTypeForOldUrlSearchByRequestPath2
		$I->comment("Exiting Action Group [searchByRequestPath2] AdminSearchByRequestPathActionGroup");
	}
}
