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
 * @Title("MC-39300: Form Key value should be updated by js script")
 * @Description("Form Key value should be updated by js script<h3>Test files</h3>app/code/Magento/PageCache/Test/Mftf/Test/StorefrontCachedInputFormKeyValueUpdatedTest.xml<br>")
 * @TestCaseId("MC-39300")
 * @group pageCache
 */
class StorefrontCachedInputFormKeyValueUpdatedTestCest
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
		$I->comment("Create Data");
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
		$I->comment("Entering Action Group [cleanCache] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanCache = $I->magentoCLI("cache:clean", 60, "full_page"); // stepKey: cleanSpecifiedCacheCleanCache
		$I->comment($cleanSpecifiedCacheCleanCache);
		$I->comment("Exiting Action Group [cleanCache] CliCacheCleanActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete data");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
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
	 * @Features({"PageCache"})
	 * @Stories({"FormKey"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCachedInputFormKeyValueUpdatedTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$grabCachedValue = $I->grabValueFrom("input[name='form_key']"); // stepKey: grabCachedValue
		$I->resetCookie("PHPSESSID"); // stepKey: resetSessionCookie
		$I->resetCookie("form_key"); // stepKey: resetFormKeyCookie
		$I->comment("Entering Action Group [reopenProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageReopenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedReopenProductPage
		$I->comment("Exiting Action Group [reopenProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [assertValueIsUpdatedByScript] AssertStorefrontAddToCartFormKeyValueIsNotCachedActionGroup");
		$grabUpdatedValueAssertValueIsUpdatedByScript = $I->grabValueFrom("input[name='form_key']"); // stepKey: grabUpdatedValueAssertValueIsUpdatedByScript
		$I->assertRegExp("/\w{16}/", $grabCachedValue); // stepKey: validateCachedFormKeyAssertValueIsUpdatedByScript
		$I->assertRegExp("/\w{16}/", $grabUpdatedValueAssertValueIsUpdatedByScript); // stepKey: validateUpdatedFormKeyAssertValueIsUpdatedByScript
		$I->assertNotEquals($grabCachedValue, $grabUpdatedValueAssertValueIsUpdatedByScript); // stepKey: assertFormKeyUpdatedAssertValueIsUpdatedByScript
		$I->comment("Exiting Action Group [assertValueIsUpdatedByScript] AssertStorefrontAddToCartFormKeyValueIsNotCachedActionGroup");
	}
}
