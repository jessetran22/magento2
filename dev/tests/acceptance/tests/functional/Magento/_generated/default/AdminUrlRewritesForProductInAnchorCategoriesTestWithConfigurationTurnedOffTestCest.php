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
 * @Title("MC-6844: Url-rewrites for product in anchor categories with configuration turned off")
 * @Description("For a product with category that has parent anchor categories, the rewrites is created when the category/product is saved.<h3>Test files</h3>app/code/Magento/UrlRewrite/Test/Mftf/Test/AdminUrlRewritesForProductInAnchorCategoriesTest/AdminUrlRewritesForProductInAnchorCategoriesTestWithConfigurationTurnedOffTest.xml<br>")
 * @TestCaseId("MC-6844")
 * @group urlRewrite
 */
class AdminUrlRewritesForProductInAnchorCategoriesTestWithConfigurationTurnedOffTestCest
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
		$I->createEntity("simpleSubCategory2", "hook", "SubCategoryWithParent", ["simpleSubCategory1"], []); // stepKey: simpleSubCategory2
		$I->createEntity("simpleSubCategory3", "hook", "SubCategoryWithParent", ["simpleSubCategory2"], []); // stepKey: simpleSubCategory3
		$I->comment("Create Simple product 1 and assign it to Category 3");
		$I->createEntity("createSimpleProduct", "hook", "ApiSimpleProduct", ["simpleSubCategory3"], []); // stepKey: createSimpleProduct
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
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Stories({"Url-rewrites for product in anchor categories"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUrlRewritesForProductInAnchorCategoriesTestWithConfigurationTurnedOffTest(AcceptanceTester $I)
	{
		$I->comment("Preconditions");
		$I->comment("Create 3 categories");
		$I->comment("Steps");
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
		$I->comment("Entering Action Group [seeValueOne] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: seeValueInGridSeeValueOne
		$I->comment("Exiting Action Group [seeValueOne] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [doNotSeeValueTwo] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->dontSeeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: valueIsNotShownInGridDoNotSeeValueTwo
		$I->comment("Exiting Action Group [doNotSeeValueTwo] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [doNotSeeValueThree] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->dontSeeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory2', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: valueIsNotShownInGridDoNotSeeValueThree
		$I->comment("Exiting Action Group [doNotSeeValueThree] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [doNotSeeValueFour] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->dontSeeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory2', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory3', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: valueIsNotShownInGridDoNotSeeValueFour
		$I->comment("Exiting Action Group [doNotSeeValueFour] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->comment("3. Edit Category 1 for DEFAULT Store View:");
		$I->comment("Entering Action Group [switchStoreView] SwitchCategoryStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageSwitchStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1SwitchStoreView
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('simpleSubCategory1', 'name', 'test') . "')]"); // stepKey: navigateToCreatedCategorySwitchStoreView
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategorySwitchStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2SwitchStoreView
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerSwitchStoreView
		$I->scrollToTopOfPage(); // stepKey: scrollToToggleSwitchStoreView
		$I->click("#store-change-button"); // stepKey: openStoreViewDropDownSwitchStoreView
		$I->click("//div[contains(@class, 'store-switcher')]//a[normalize-space()='Default Store View']"); // stepKey: selectStoreViewSwitchStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3SwitchStoreView
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinner2SwitchStoreView
		$I->click(".modal-popup.confirm._show .action-accept"); // stepKey: selectStoreViewAcceptSwitchStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewChangeLoadSwitchStoreView
		$I->comment("Exiting Action Group [switchStoreView] SwitchCategoryStoreViewActionGroup");
		$I->comment("4. Change URL key for category and save changes");
		$I->comment("Entering Action Group [changeCategoryUrlKey] ChangeSeoUrlKeyForSubCategoryActionGroup");
		$I->conditionalClick("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", "div[data-index='search_engine_optimization'] .admin__fieldset-wrapper-content", false); // stepKey: openSeoSectionChangeCategoryUrlKey
		$I->uncheckOption("input[name='use_default[url_key]']"); // stepKey: uncheckDefaultValueChangeCategoryUrlKey
		$I->fillField("input[name='url_key']", $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "new"); // stepKey: enterURLKeyChangeCategoryUrlKey
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryChangeCategoryUrlKey
		$I->waitForPageLoad(30); // stepKey: saveCategoryChangeCategoryUrlKeyWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessageChangeCategoryUrlKey
		$I->comment("Exiting Action Group [changeCategoryUrlKey] ChangeSeoUrlKeyForSubCategoryActionGroup");
		$I->comment("5. Open Marketing - SEO & Search - URL Rewrites");
		$I->comment("Entering Action Group [searchingUrlRewriteOneMoreTime] AdminSearchUrlRewriteByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchingUrlRewriteOneMoreTime
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchingUrlRewriteOneMoreTime
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchingUrlRewriteOneMoreTime
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchingUrlRewriteOneMoreTimeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchingUrlRewriteOneMoreTime
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchingUrlRewriteOneMoreTime
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchingUrlRewriteOneMoreTimeWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: fillRequestPathFilterSearchingUrlRewriteOneMoreTime
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchingUrlRewriteOneMoreTime
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchingUrlRewriteOneMoreTimeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchingUrlRewriteOneMoreTime
		$I->comment("Exiting Action Group [searchingUrlRewriteOneMoreTime] AdminSearchUrlRewriteByRequestPathActionGroup");
		$I->comment("Entering Action Group [seeValueInGrid] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: seeValueInGridSeeValueInGrid
		$I->comment("Exiting Action Group [seeValueInGrid] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [doNotSeeValueTwoInGrid] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->dontSeeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: valueIsNotShownInGridDoNotSeeValueTwoInGrid
		$I->comment("Exiting Action Group [doNotSeeValueTwoInGrid] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [doNotSeeValueThreeInGrid] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->dontSeeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory2', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: valueIsNotShownInGridDoNotSeeValueThreeInGrid
		$I->comment("Exiting Action Group [doNotSeeValueThreeInGrid] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [doNotSeeValueFourInGrid] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->dontSeeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory2', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory3', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: valueIsNotShownInGridDoNotSeeValueFourInGrid
		$I->comment("Exiting Action Group [doNotSeeValueFourInGrid] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [doNotSeeValueFiveInGrid] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->dontSeeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "-new/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: valueIsNotShownInGridDoNotSeeValueFiveInGrid
		$I->comment("Exiting Action Group [doNotSeeValueFiveInGrid] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [doNotSeeValueSixInGrid] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->dontSeeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "-new/" . $I->retrieveEntityField('simpleSubCategory2', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: valueIsNotShownInGridDoNotSeeValueSixInGrid
		$I->comment("Exiting Action Group [doNotSeeValueSixInGrid] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [doNotSeeValueSevenInGrid] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->dontSeeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "-new/" . $I->retrieveEntityField('simpleSubCategory2', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory3', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: valueIsNotShownInGridDoNotSeeValueSevenInGrid
		$I->comment("Exiting Action Group [doNotSeeValueSevenInGrid] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->comment("6. Assert Redirects work and Product is present on StoreFront");
		$I->comment("Entering Action Group [verifyProductInStoreFrontPage] AssertStorefrontProductRedirectActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openCategoryInStorefrontVerifyProductInStoreFrontPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadVerifyProductInStoreFrontPage
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".base"); // stepKey: seeProductNameInStoreFrontPageVerifyProductInStoreFrontPage
		$I->see($I->retrieveEntityField('createSimpleProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: seeProductSkuInStoreFrontPageVerifyProductInStoreFrontPage
		$I->comment("Exiting Action Group [verifyProductInStoreFrontPage] AssertStorefrontProductRedirectActionGroup");
		$I->comment("Entering Action Group [verifyProductInStoreFrontPageSecondAttempt] AssertStorefrontProductRedirectActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openCategoryInStorefrontVerifyProductInStoreFrontPageSecondAttempt
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadVerifyProductInStoreFrontPageSecondAttempt
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".base"); // stepKey: seeProductNameInStoreFrontPageVerifyProductInStoreFrontPageSecondAttempt
		$I->see($I->retrieveEntityField('createSimpleProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: seeProductSkuInStoreFrontPageVerifyProductInStoreFrontPageSecondAttempt
		$I->comment("Exiting Action Group [verifyProductInStoreFrontPageSecondAttempt] AssertStorefrontProductRedirectActionGroup");
		$I->comment("Entering Action Group [verifyProductInStoreFrontPageThirdAttempt] AssertStorefrontProductRedirectActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory2', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openCategoryInStorefrontVerifyProductInStoreFrontPageThirdAttempt
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadVerifyProductInStoreFrontPageThirdAttempt
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".base"); // stepKey: seeProductNameInStoreFrontPageVerifyProductInStoreFrontPageThirdAttempt
		$I->see($I->retrieveEntityField('createSimpleProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: seeProductSkuInStoreFrontPageVerifyProductInStoreFrontPageThirdAttempt
		$I->comment("Exiting Action Group [verifyProductInStoreFrontPageThirdAttempt] AssertStorefrontProductRedirectActionGroup");
		$I->comment("Entering Action Group [verifyProductInStoreFrontPageFourthAttempt] AssertStorefrontProductRedirectActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory2', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory3', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openCategoryInStorefrontVerifyProductInStoreFrontPageFourthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadVerifyProductInStoreFrontPageFourthAttempt
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".base"); // stepKey: seeProductNameInStoreFrontPageVerifyProductInStoreFrontPageFourthAttempt
		$I->see($I->retrieveEntityField('createSimpleProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: seeProductSkuInStoreFrontPageVerifyProductInStoreFrontPageFourthAttempt
		$I->comment("Exiting Action Group [verifyProductInStoreFrontPageFourthAttempt] AssertStorefrontProductRedirectActionGroup");
		$I->comment("Entering Action Group [verifyProductInStoreFrontPageFifthAttempt] AssertStorefrontProductRedirectActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "new/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openCategoryInStorefrontVerifyProductInStoreFrontPageFifthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadVerifyProductInStoreFrontPageFifthAttempt
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".base"); // stepKey: seeProductNameInStoreFrontPageVerifyProductInStoreFrontPageFifthAttempt
		$I->see($I->retrieveEntityField('createSimpleProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: seeProductSkuInStoreFrontPageVerifyProductInStoreFrontPageFifthAttempt
		$I->comment("Exiting Action Group [verifyProductInStoreFrontPageFifthAttempt] AssertStorefrontProductRedirectActionGroup");
		$I->comment("Entering Action Group [verifyProductInStoreFrontPageSixthAttempt] AssertStorefrontProductRedirectActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "new/" . $I->retrieveEntityField('simpleSubCategory2', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openCategoryInStorefrontVerifyProductInStoreFrontPageSixthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadVerifyProductInStoreFrontPageSixthAttempt
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".base"); // stepKey: seeProductNameInStoreFrontPageVerifyProductInStoreFrontPageSixthAttempt
		$I->see($I->retrieveEntityField('createSimpleProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: seeProductSkuInStoreFrontPageVerifyProductInStoreFrontPageSixthAttempt
		$I->comment("Exiting Action Group [verifyProductInStoreFrontPageSixthAttempt] AssertStorefrontProductRedirectActionGroup");
		$I->comment("Entering Action Group [verifyProductInStoreFrontPageSeventhAttempt] AssertStorefrontProductRedirectActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "new/" . $I->retrieveEntityField('simpleSubCategory2', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory3', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openCategoryInStorefrontVerifyProductInStoreFrontPageSeventhAttempt
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadVerifyProductInStoreFrontPageSeventhAttempt
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".base"); // stepKey: seeProductNameInStoreFrontPageVerifyProductInStoreFrontPageSeventhAttempt
		$I->see($I->retrieveEntityField('createSimpleProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: seeProductSkuInStoreFrontPageVerifyProductInStoreFrontPageSeventhAttempt
		$I->comment("Exiting Action Group [verifyProductInStoreFrontPageSeventhAttempt] AssertStorefrontProductRedirectActionGroup");
	}
}
