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
 * @Title("MC-15944: Store code should be added to storefront URL if the corresponding configuration is enabled")
 * @Description("Store code should be added to storefront URL if the corresponding configuration is enabled<h3>Test files</h3>app/code/Magento/Store/Test/Mftf/Test/StorefrontAddStoreCodeInUrlTest.xml<br>")
 * @TestCaseId("MC-15944")
 * @group store
 * @group mtf_migrated
 */
class StorefrontAddStoreCodeInUrlTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$addStoreCodeToUrlEnable = $I->magentoCLI("config:set web/url/use_store 1", 60); // stepKey: addStoreCodeToUrlEnable
		$I->comment($addStoreCodeToUrlEnable);
		$I->comment("Entering Action Group [flushPageCache] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushPageCache = $I->magentoCLI("cache:flush", 60, "full_page"); // stepKey: flushSpecifiedCacheFlushPageCache
		$I->comment($flushSpecifiedCacheFlushPageCache);
		$I->comment("Exiting Action Group [flushPageCache] CliCacheFlushActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$addStoreCodeToUrlDisable = $I->magentoCLI("config:set web/url/use_store 0", 60); // stepKey: addStoreCodeToUrlDisable
		$I->comment($addStoreCodeToUrlDisable);
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
	 * @Features({"Store"})
	 * @Stories({"Admin Panel URL with Store Code"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontAddStoreCodeInUrlTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [clickOnStorefrontHeaderLogo] StorefrontClickOnHeaderLogoActionGroup");
		$I->amOnPage("/"); // stepKey: goToHomePageClickOnStorefrontHeaderLogo
		$I->waitForPageLoad(30); // stepKey: waitForHomePageLoadedClickOnStorefrontHeaderLogo
		$I->click(".header .logo"); // stepKey: clickOnLogoClickOnStorefrontHeaderLogo
		$I->waitForPageLoad(30); // stepKey: waitForHomePageLoadedAfterClickOnLogoClickOnStorefrontHeaderLogo
		$I->comment("Exiting Action Group [clickOnStorefrontHeaderLogo] StorefrontClickOnHeaderLogoActionGroup");
		$I->comment("Entering Action Group [seeStoreCodeInUrl] AssertStorefrontStoreCodeInUrlActionGroup");
		$I->seeInCurrentUrl("/default"); // stepKey: seeStoreCodeInURLSeeStoreCodeInUrl
		$I->comment("Exiting Action Group [seeStoreCodeInUrl] AssertStorefrontStoreCodeInUrlActionGroup");
	}
}
