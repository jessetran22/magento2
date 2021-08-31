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
 * @Title("MAGETWO-94803: No auto generated of request path for simple product when assigned to subCategory")
 * @Description("No auto generated of request path when SEO configuration to Generate url rewrite for Generate 'category/product' URL Rewrites is set to No<h3>Test files</h3>app/code/Magento/UrlRewrite/Test/Mftf/Test/AdminUrlRewritesForProductInAnchorCategoriesTest/AdminUrlRewritesForProductsWithConfigurationTurnedOffTest.xml<br>")
 * @TestCaseId("MAGETWO-94803")
 * @group urlRewrite
 */
class AdminUrlRewritesForProductsWithConfigurationTurnedOffTestCest
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
		$I->comment("Set the configuration for Generate \"category/product\" URL Rewrites to Yes (default)");
		$I->comment("Enable SEO configuration setting to generate category/product URL Rewrites");
		$enableGenerateUrlRewrite = $I->magentoCLI("config:set catalog/seo/generate_category_product_rewrites 1", 60); // stepKey: enableGenerateUrlRewrite
		$I->comment($enableGenerateUrlRewrite);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->createEntity("simpleSubCategory1", "hook", "SimpleSubCategory", [], []); // stepKey: simpleSubCategory1
		$I->comment("Create Simple product 1 and assign it to Category 1");
		$I->createEntity("createSimpleProduct", "hook", "ApiSimpleProduct", ["simpleSubCategory1"], []); // stepKey: createSimpleProduct
		$I->comment("Set the configuration for Generate \"category/product\" URL Rewrites to No");
		$I->comment("Disable SEO configuration setting to generate category/product URL Rewrites");
		$disableGenerateUrlRewrite = $I->magentoCLI("config:set catalog/seo/generate_category_product_rewrites 0", 60); // stepKey: disableGenerateUrlRewrite
		$I->comment($disableGenerateUrlRewrite);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("simpleSubCategory1", "hook"); // stepKey: deletesimpleSubCategory1
		$resetConfigurationSetting = $I->magentoCLI("config:set catalog/seo/generate_category_product_rewrites 1", 60); // stepKey: resetConfigurationSetting
		$I->comment($resetConfigurationSetting);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
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
	 * @Features({"UrlRewrite"})
	 * @Stories({"No Url-rewrites for product if configuration to generate url rewrite for Generate 'category/product' URL Rewrites is enabled"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUrlRewritesForProductsWithConfigurationTurnedOffTest(AcceptanceTester $I)
	{
		$I->comment("1. Log in to Admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("2. Open Marketing - SEO & Search - URL Rewrites");
		$I->comment("Entering Action Group [searchingUrlRewrite] AdminSearchUrlRewriteByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchingUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchingUrlRewrite
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchingUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchingUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchingUrlRewrite
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchingUrlRewrite
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchingUrlRewriteWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: fillRequestPathFilterSearchingUrlRewrite
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchingUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchingUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchingUrlRewrite
		$I->comment("Exiting Action Group [searchingUrlRewrite] AdminSearchUrlRewriteByRequestPathActionGroup");
		$I->comment("Entering Action Group [seeProductUrlInGrid] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: seeValueInGridSeeProductUrlInGrid
		$I->comment("Exiting Action Group [seeProductUrlInGrid] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [categoryProductUrlIsNotShown] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->dontSeeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: valueIsNotShownInGridCategoryProductUrlIsNotShown
		$I->comment("Exiting Action Group [categoryProductUrlIsNotShown] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->comment("3. Assert the Redirect works and Product is present on StoreFront");
		$I->comment("Entering Action Group [verifyProductInStoreFrontPage] AssertStorefrontProductRedirectActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openCategoryInStorefrontVerifyProductInStoreFrontPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadVerifyProductInStoreFrontPage
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".base"); // stepKey: seeProductNameInStoreFrontPageVerifyProductInStoreFrontPage
		$I->see($I->retrieveEntityField('createSimpleProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: seeProductSkuInStoreFrontPageVerifyProductInStoreFrontPage
		$I->comment("Exiting Action Group [verifyProductInStoreFrontPage] AssertStorefrontProductRedirectActionGroup");
	}
}
